<?php


namespace Repository\DeliveryOption;


use App\Models\DeliveryOption;
use Repository\Repository;
use Illuminate\Support\Collection;

class DeliveryOptionRepository extends Repository
{

    public function model()
    {
        return DeliveryOption::class;
    }

    public function getBestOption($merchantId) : ? DeliveryOption
    {
        return $this->model()::merchant($merchantId)
            ->orderByDesc('threshold_amount')
            ->orderBy('price')
            ->first();
    }

    public function getByMarchantId($merchantId) : Collection
    {
        return $this->model()::merchant($merchantId)
                ->orderByDesc('threshold_amount')
                ->orderBy('price')
                ->get();
    }
}
