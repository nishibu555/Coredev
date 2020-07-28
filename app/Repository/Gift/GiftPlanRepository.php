<?php


namespace App\Repository\Gift;


use App\Models\Gift\GiftPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Repository\Repository;

class GiftPlanRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return GiftPlan::class;
    }


    public function findOrFailOnGoingPlan($planId): ?GiftPlan
    {
        return $this->model()::where('status', 'planning')->findOrFail($planId);
    }

    public function confirmPlan(GiftPlan $giftPlan)
    {
        return $this->update($giftPlan, ['status' => 'planned']);
    }

    public function findPlanByToken($token)
    {
        return $this->model()::where('claiming_token', $token)->first();
    }

    public function planByReceiver($userId, $status = 'planned')
    {
        $query = $this->model()::where('receiver_id', $userId);
        if (is_array($status)) {
            return $query->whereIn('status', $status);
        } else {
            return $query->where('status', $status);
        }
    }

    public function planById($planId, $userId)
    {
        return $this->planByReceiver($userId)->findOrFail($planId);
    }

    public function updateStatus(GiftPlan $giftPlan, $status)
    {
        $this->update($giftPlan, ['status' => $status]);
    }

    public function getOngoingPlan($userId, $limit = null)
    {
        $outGoingGift = $this->model()::where('sender_id', $userId)
                    ->where('status', '!=', 'sent')->limit($limit)->get();
        $incomingGift = $this->planByReceiver($userId, ['planned', 'accepted'])->limit($limit)->get();

       return [
           'incoming' => $incomingGift,
           'outGoing' => $outGoingGift
       ];
    }
}
