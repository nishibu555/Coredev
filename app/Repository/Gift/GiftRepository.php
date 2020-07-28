<?php


namespace App\Repository\Gift;


use App\Models\Gift\Gift;
use App\Models\Gift\GiftPlan;
use App\Services\Feed\FeedApiService;
use Repository\Repository;

class GiftRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Gift::class;
    }

    public function storeSelectedGift($request, GiftPlan $giftPlan)
    {
        $product = app(FeedApiService::class)->get('products/' . $request->product_id);

        if ($product) {
            return $this->model()::create([
                'plan_id' => $giftPlan->id,
                'product_id' => $product->id,
                'sender_budget' => $giftPlan->budget,
                'color' => $request->color,
                'size' => $request->size,
                'price' => $product->price,
            ]);
        }

        return [];
    }


    public function isProductAdded($planId, $productId)
    {
        return $this->model()::where('plan_id', $planId)
            ->where('product_id', $productId)->exists();
    }

    public function findByPlan($planId)
    {
        return $this->model()::where('plan_id', $planId)->first();
    }

    public function updateBuyStatus($productId, $planId, int $hasBought)
    {
        return $this->model()::where('product_id', $productId)
            ->where( 'plan_id', $planId)
            ->update(['hasBought' => $hasBought]);
    }
}
