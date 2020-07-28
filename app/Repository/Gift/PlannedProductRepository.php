<?php


namespace App\Repository\Gift;


use App\Models\PlannedProduct;
use Illuminate\Support\Collection;
use Repository\Repository;

class PlannedProductRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return PlannedProduct::class;
    }

    public function getProductIds($planId):Collection
    {
        return $this->model()::where('plan_id', $planId)->pluck('product_id');
    }

    public function countPlannedProduct($planId)
    {
        return $this->model()::where('plan_id', $planId)->count();
    }

    public function deletePlannedProduct($planId, $productId)
    {
       return $this->model()::where('plan_id', $planId)->where('product_id', $productId)->delete();
    }

    public function findProductByPlan($planId, $productId)
    {
        return $this->model()::where('plan_id', $planId)->where('product_id', $productId)->first();
    }
}
