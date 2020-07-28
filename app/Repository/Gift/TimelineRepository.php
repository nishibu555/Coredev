<?php


namespace App\Repository\Gift;

use App\Models\Gift\Gift;
use App\Models\Gift\GiftPlan;
use App\Models\Timeline;
use Illuminate\Support\Collection;
use Repository\Repository;

class TimelineRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Timeline::class;
    }

    public function getByUserId($userId): Collection
    {
        return $this->getGift(['user_id' => $userId])->get();
    }

    public function getReportByUserId($userId)
    {
        $sentGifts = $this->getGift(['user_id' => $userId, 'action' => 'sent'])->get();
        $receivedGifts = $this->getGift(['user_id' => $userId, 'action' => 'received'])->get();
        $percentage = $this->getPercentage($userId);
        return [
            'received' => [
                'total' => count($receivedGifts),
                'amount' => $receivedGifts->sum('price'),
                'percentage_by_gift' => round($percentage['sent']['percentage_by_gift'], 2),
                'percentage_by_price' => round($percentage['sent']['percentage_by_price'], 2),
            ],
            'sent' => [
                'total' => count($sentGifts),
                'amount' => $sentGifts->sum('price'),
                'percentage_by_gift' => round($percentage['received']['percentage_by_gift'], 2),
                'percentage_by_price' => round($percentage['received']['percentage_by_price'], 2),
            ]
        ];
    }

    private function getGift($queryParams)
    {
        return Timeline::where(function ($query) use($queryParams) {
            foreach ($queryParams as $field => $value) {
                $query->where([$field => $value]);
            }
        });
    }

    private function getGiftsByMonth($queryParams, $month)
    {
        return $this->getGift($queryParams)
            ->whereMonth('event_date', '=', $month)
            ->get();
    }

    private function getPercentage($userId)
    {
        $currentMonthSentGifts = $this->getGiftsByMonth(
            ['user_id' => $userId, 'action' => 'sent'],
            now()->month
        );

        $lastMonthSentGifts = $this->getGiftsByMonth(
            ['user_id' => $userId, 'action' => 'sent'],
            now()->subMonth()->month
        );

        $currentMonthReceiveddGifts = $this->getGiftsByMonth(
            ['user_id' => $userId, 'action' => 'received'],
            now()->month
        );

        $lastMonthReceivedGifts = $this->getGiftsByMonth(
            ['user_id' => $userId, 'action' => 'received'],
            now()->subMonth()->month
        );

        $sentIncreaseByTotalGift = (count($currentMonthSentGifts) - count($lastMonthSentGifts));
        $sentIncreaseByTotalPrice = ($currentMonthSentGifts->sum('price') - $lastMonthSentGifts->sum('price'));
        $receivedIncreaseByTotalGift = (count($currentMonthReceiveddGifts) - count($lastMonthReceivedGifts));
        $receivedIncreaseByTotalPrice = ($currentMonthReceiveddGifts->sum('price') - $lastMonthReceivedGifts->sum('price'));

        $sentPercentageByTotalGift = null;
        $sentPercentageByTotalPrice = null;
        $receivedPercentageByTotalGift = null;
        $receivedPercentageByTotalPrice = null;

        if(count($lastMonthSentGifts)) {
            $sentPercentageByTotalGift =  ($sentIncreaseByTotalGift / count($lastMonthSentGifts)) * 100;
        }
        if($lastMonthSentGifts->sum('price')) {
            $sentPercentageByTotalPrice =  ($sentIncreaseByTotalPrice / $lastMonthSentGifts->sum('price')) * 100;
        }

        if(count($lastMonthReceivedGifts)) {
            $receivedPercentageByTotalGift =  ($receivedIncreaseByTotalGift / count($lastMonthReceivedGifts)) * 100;
        }
        if($lastMonthReceivedGifts->sum('price')) {
            $receivedPercentageByTotalPrice =  ($receivedIncreaseByTotalPrice / $lastMonthReceivedGifts->sum('price')) * 100;
        }

        return [
            'sent' => [
                'percentage_by_gift' => $sentPercentageByTotalGift,
                'percentage_by_price' => $sentPercentageByTotalPrice,
            ],
            'received' => [
                'percentage_by_gift' => $receivedPercentageByTotalGift,
                'percentage_by_price' => $receivedPercentageByTotalPrice,
            ],
        ];
    }

    public function sentGiftByUserId($userId, $limit = null): Collection
    {
        return $this->getGift(['user_id' => $userId, 'action' => 'sent'])->limit($limit)->get();
    }

    public function receivedGiftByUserId($userId, $limit = null) : Collection
    {
        return $this->getGift(['user_id' => $userId, 'action' => 'received'])->limit($limit)->get();
    }

    public function store(GiftPlan $giftPlan, Gift $gift)
    {
        $this->save($gift, $giftPlan->sender_id, $giftPlan->receiver_id, 'sent');
        $this->save($gift, $giftPlan->receiver_id, $giftPlan->sender_id, 'received');
    }

    public function save(Gift $gift, $senderId, $receiverId, $action)
    {
       return $this->model()::create([
            'gift_plan_id' => $gift->plan_id,
            'user_id' => $senderId,
            'action_user_id' => $receiverId,
            'price' => $gift->price,
            'gift_item' => $gift->type,
            'relation' => $gift->relation,
            'occasion' => $gift->occasion,
            'action' => $action,
            'event_date' => now(),
        ]);
    }
}
