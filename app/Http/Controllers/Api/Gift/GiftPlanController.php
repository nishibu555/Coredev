<?php

namespace App\Http\Controllers\Api\Gift;

use App\Events\Gift\ConfirmedGiftPlan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Gift\BudgetPlanRequest;
use App\Http\Requests\Api\Gift\InitiateGiftPlanRequest;
use App\Http\Requests\Api\Gift\ReceiverInfoRequest;
use App\Http\Resources\Api\Gift\ClaimGiftPlan;
use App\Http\Resources\Api\Gift\GiftPlan;
use App\Http\Resources\Api\Gift\Timeline;
use App\Models\User\User;
use App\Repository\Gift\GiftPlanRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Repository\User\UserRepository;
use Repository\User\VerificationCodeRepository;
use \App\Http\Resources\Api\User\User as UserResource;

class GiftPlanController extends Controller
{


    /**
     * @var GiftPlanRepository
     */
    private $giftPlanRepo;
    private $codeRepo;

    public function __construct(GiftPlanRepository $giftPlanRepo, VerificationCodeRepository $codeRepo)
    {
        $this->giftPlanRepo = $giftPlanRepo;
        $this->codeRepo = $codeRepo;
    }

    public function initiatePlan(InitiateGiftPlanRequest $request)
    {
        $data = $this->formatGiftPlan($request);
        $giftPlan = $this->giftPlanRepo->create($data);
        return $this->json('Gift plan initiated!', new GiftPlan($giftPlan));
    }

    public function updatePlan($planId, InitiateGiftPlanRequest $request)
    {
        $giftPlan = $this->giftPlanRepo->findOrFailOnGoingPlan($planId);

        $this->giftPlanRepo->update($giftPlan,
            [
                'relation' => $request->get('relation'),
                'occasion' => $request->get('occasion'),
                'giftee_gender' => $request->get('gender'),
                'giftee_age_range' => $request->get('age_range'),
                'budget' => $request->get('budget') ?? $giftPlan->budget,
            ]);

        return $this->json('Gift plan updated!', new GiftPlan($giftPlan));
    }

    public function storeBudget($planId, BudgetPlanRequest $request)
    {
        $giftPlan = $this->giftPlanRepo->findOrFailOnGoingPlan($planId);

        $data = $request->only('budget', 'share_budget', 'is_anonymous', 'idea_level');

        $this->giftPlanRepo->update($giftPlan, $data);

        return $this->json('Gift budget planned successfully!', new GiftPlan($giftPlan));
    }

    public function storeReceiver($planId, ReceiverInfoRequest $request, UserRepository $userRepo)
    {
        $giftPlan = $this->giftPlanRepo->findOrFailOnGoingPlan($planId);

        if ($request->filled('receiver_id')) {
            $receiver = $userRepo->findOrFail($request->get('receiver_id'));
        } else {
            $receiver = $this->findUserByEmailOrPhone($request, $userRepo);

            if (is_null($receiver)) {
                $receiver = $userRepo->create($this->formatUser($request));
            } elseif (!$receiver->is_active) {
                $userRepo->update($receiver, $this->formatUser($request));
            }
        }

        $this->giftPlanRepo->update($giftPlan, [
            'giftee_name' => $request->get('giftee_name'),
            'receiver_id' => $receiver->id,
            'receiver_relation_with_giftee' => $request->get('relation_with_giftee'),
            'is_required_delivery_address' => $request->get('is_required_delivery_address'),
        ]);

        return $this->json('Receiver information saved successfully!', new GiftPlan($giftPlan));
    }

    public function confirm($planId, GiftPlanRepository $giftPlanRepo)
    {
        $giftPlan = $giftPlanRepo->findOrFailOnGoingPlan($planId);
        $receiver = $giftPlan->receiver;

        if (is_null($receiver)) {
            return $this->json('No receiver exists!', [], Response::HTTP_BAD_REQUEST);
        }

        $giftPlanRepo->confirmPlan($giftPlan);
        //Generate a token
        $token = $this->codeRepo->generateUniqueToken();
        $giftPlan->update(['claiming_token' => $token]);
        //Generate a link using the above token and has receiver account flag
        $link = $this->makeLinkForChoosingGift($giftPlan, $token);
        event(new ConfirmedGiftPlan($giftPlan, $link));
        return $this->json('Thank for confirming your gift plan! The receiver is being notified', ['token' => $token]);
    }

    public function updateReceiver($planId, ReceiverInfoRequest $request, UserRepository $userRepo)
    {
        $giftPlan = $this->giftPlanRepo->findOrFailOnGoingPlan($planId);
        $receiver = $giftPlan->receiver;

        if (is_null($receiver)) {
            return $this->json('No receiver exists to update!', [], Response::HTTP_BAD_REQUEST);
        }

        if ($receiver->is_active) {
            return $this->json('Already active receiver cannot be updated!', [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userRepo->update($receiver, $this->formatUser($request));

        $this->giftPlanRepo->update($giftPlan, [
            'giftee_name' => $request->get('giftee_name'),
            'receiver_id' => $receiver->id,
            'receiver_relation_with_giftee' => $request->get('relation_with_giftee')
        ]);

        return $this->json('Receiver information updated successfully!', new GiftPlan($giftPlan));
    }

    public function show($planId, GiftPlanRepository $giftPlanRepo)
    {
        $giftPlan = $giftPlanRepo->findOrFail($planId);
        return new GiftPlan($giftPlan);
    }

    private function findUserByEmailOrPhone(ReceiverInfoRequest $request, UserRepository $userRepo): ?User
    {
        $receiver = $userRepo->findByPhone($request->get('phone'));
        if (is_null($receiver) && $request->filled('email')) {
            $receiver = $userRepo->findByEmail($request->get('email'));
        }
        return $receiver;
    }

    private function formatUser(ReceiverInfoRequest $request)
    {
        return [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'is_active' => 0,
        ];
    }


    private function formatGiftPlan(InitiateGiftPlanRequest $request): array
    {
        return [
            'sender_id' => auth()->id(),
            'relation' => $request->get('relation'),
            'occasion' => $request->get('occasion'),
            'giftee_age_range' => $request->get('age_range'),
            'giftee_gender' => $request->get('gender'),
            'status' => 'planning',
            'occasion_date' => $request->get('occasion_date'),
        ];
    }

    public function makeLinkForChoosingGift($giftPlan, $token)
    {
        $link = trim(config('app.frontend_url'), '/\\') .
            '/gift/choose/?has_account='.$giftPlan->receiver->is_active.
            '&token='.$token;

        $shortener = app('url.shortener');
        return $shortener->shorten($link);
    }

    public function getReceiver($token) {
        $giftPlan = $this->giftPlanRepo->findPlanByToken($token);
        if ($giftPlan->receiver) {
            return $this->json('Receiver info found successfully', new ClaimGiftPlan($giftPlan));
        }
        return $this->json('No receiver found!', [], Response::HTTP_BAD_REQUEST);
    }

    public function getOngoing(Request $request)
    {
        $giftPlans = $this->giftPlanRepo->getOngoingPlan(auth()->id(), $request->get('limit'));
        $data = [
            'incoming' => GiftPlan::collection($giftPlans['incoming']),
            'outGoing' => GiftPlan::collection($giftPlans['outGoing'])
        ];

        return $this->json('Get ongoing gifts successfully!', $data);
    }

    public function viewRequest($giftPlanId)
    {
        $giftPlan = $this->giftPlanRepo->findOrFail($giftPlanId);

        $giftPlan->update(['viewed_at' => now()]);

        return $this->json('Gift viewed successfully!', new GiftPlan($giftPlan));
    }

    public function ignoreRequest($giftPlanId)
    {
        $giftPlan = $this->giftPlanRepo->findOrFail($giftPlanId);

        $giftPlan->update(['ignored_at' => now()]);

        return $this->json('Gift ignored successfully!', new GiftPlan($giftPlan));
    }
}
