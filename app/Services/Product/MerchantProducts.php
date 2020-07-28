<?php


namespace App\Services\Product;


use Illuminate\Support\Collection;

class MerchantProducts extends Collection
{
    public function push($product)
    {
        if (!$product instanceof MerchantProduct) {
            throw new \InvalidArgumentException("Product must be instance of " . MerchantProduct::class);
        }
        parent::push($product);
        return $this;
    }

    public function add($product)
    {
        return $this->push($product);
    }
}
