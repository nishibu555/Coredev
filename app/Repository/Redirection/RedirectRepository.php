<?php

namespace Repository\Redirection;


use App\Models\Gift\Gift;
use App\Models\Gift\GiftPlan;
use App\Models\Redirection;
use App\Repository\Gift\GiftPlanRepository;
use App\Repository\Gift\GiftRepository;
use Repository\Repository;
use Auth;

class RedirectRepository extends Repository
{
    protected $giftRepo;
    protected $giftPlanRepo;

    public function __construct(GiftRepository $giftRepo, GiftPlanRepository $giftPlanRepo)
    {
        $this->giftRepo = $giftRepo;
        $this->giftPlanRepo = $giftPlanRepo;
    }

    public function model()
    {
        return Redirection::class;
    }

    public function redirectUrl($request)
    {
        $gift = $this->giftRepo->findByPlan($request->planId);
        $url = $gift->product_url ?: '';
        $userId = $this->giftPlanRepo->findOrFail($request->planId)->value('sender_id');
        $this->model()::updateOrCreate(
            ['plan_id' => $request->planId, 'user_id' => $userId],
            [
                'url' =>  $url
            ]
        );
        return $url;
    }
}
