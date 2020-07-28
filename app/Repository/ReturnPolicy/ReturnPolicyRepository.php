<?php


namespace Repository\ReturnPolicy;

use App\Models\ReturnPolicy;
use Repository\Repository;

class ReturnPolicyRepository extends Repository
{

    public function model()
    {
        return ReturnPolicy::class;
    }

    public function getReturnPolicy($merchantId)
    {
        return ReturnPolicy::where('merchant_id', $merchantId)->first();
    }
}
