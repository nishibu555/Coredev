<?php

namespace App\Http\Controllers\Api\Gift;

use App\Events\Gift\ReceiverGiftChoosen;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Gift\Gift;
use App\Http\Resources\Api\Gift\GiftPlan;
use App\Repository\Address\AddressRepository;
use App\Repository\Gift\GiftPlanRepository;
use App\Repository\Gift\GiftRepository;
use App\Repository\Gift\PlannedProductRepository;
use App\Repository\Gift\TimelineRepository;
use Illuminate\Http\Request;
use Repository\User\VerificationCodeRepository;

class GiftController extends Controller
{
    protected $giftPlanRepo;
    protected $plannedProductRepo;
    protected $giftRepo;
    protected $timelineRepo;
    protected $codeRepo;
    protected $addressRepo;

    public function __construct(
        GiftPlanRepository $giftPlanRepo,
        PlannedProductRepository $plannedProductRepo,
        GiftRepository $giftRepo,
        TimelineRepository $timelineRepo,
        VerificationCodeRepository $codeRepo,
        AddressRepository $addressRepo
    ) {
        $this->giftPlanRepo = $giftPlanRepo;
        $this->plannedProductRepo = $plannedProductRepo;
        $this->giftRepo = $giftRepo;
        $this->timelineRepo = $timelineRepo;
        $this->codeRepo = $codeRepo;
        $this->addressRepo = $addressRepo;
    }

    public function getInvitedGifts(Request $request)
    {
        $gifts = $this->giftPlanRepo->planByReceiver(auth()->id())->get();

        return $this->json('Get list of gift invitation successfully!', GiftPlan::collection($gifts));
    }

    public function get($giftPlanId)
    {
        $gift = $this->giftPlanRepo->planById($giftPlanId, auth()->id());

        return $this->json('Get details of gift invitation successfully!', new GiftPlan($gift));
    }

    public function select(Request $request, $giftPlanId)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        $giftPlan = $this->giftPlanRepo->planById($giftPlanId, auth()->id());

        $isProductAdded = $this->giftRepo->isProductAdded($giftPlan->id, $request->product_id);

        if ($isProductAdded) {
            return $this->json('Already added this product into the plan');
        }
        if ($gift = $this->giftRepo->storeSelectedGift($request, $giftPlan)) {
            return $this->json('Selected product store successfully!', new Gift($gift));
        }

        return $this->json('No product found!');
    }

    public function confirm(Request $request, $giftPlanId)
    {
        $giftPlan = $this->giftPlanRepo->planByReceiver(auth()->id(), 'planned')->findOrFail($giftPlanId);

        if ($request->delivery_address) {
            $address = $this->addressRepo->create(['line1' => $request->delivery_address]);
            $giftPlan->update(['delivery_address_id' => $address->id]);
        }

        $gift = $this->giftRepo->findByPlan($giftPlanId);

        $this->giftPlanRepo->updateStatus($giftPlan, 'accepted');

        $token = $this->codeRepo->generateUniqueToken();

        $link = $this->makeLinkForLandingPage($token);
        $giftPlan->update(['claiming_token' => $token]);
        event(new ReceiverGiftChoosen($giftPlan->sender, $link));

        return $this->json('Gift confirmed successfully!', new Gift($gift));
    }

    public function confirmBuy(Request $request, GiftRepository $giftRepo)
    {
        $giftPlan = $this->giftPlanRepo->findOrFail($request->plan_id);

        $giftRepo->updateBuyStatus($request->product_id, $request->plan_id, $request->hasBought);

        $gift = $this->giftRepo->findByPlan($giftPlan->id);

        $this->giftPlanRepo->updateStatus($giftPlan,  'sent');

        $this->timelineRepo->store($giftPlan, $gift);

        return $this->json('Gift buying confirmation status has set successfully!');
    }

    private function makeLinkForLandingPage($token)
    {
        $link = trim(config('app.frontend_url'), '/\\') .
            '/gift/choosen/?token='.$token;

        $shortener = app('url.shortener');
        return $shortener->shorten($link);
    }
}
