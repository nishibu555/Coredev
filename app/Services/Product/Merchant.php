<?php


namespace App\Services\Product;

abstract class Merchant
{
    abstract public function getProducts($category): MerchantProducts;
}
