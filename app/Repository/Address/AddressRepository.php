<?php


namespace App\Repository\Address;


use App\Models\Address;
use Repository\Repository;

class AddressRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Address::class;
    }
}
