<?php


namespace App\Services\Product\Amazon;


use App\Services\Product\Merchant;
use App\Services\Product\MerchantProducts;

class DummyAmazon extends Merchant
{

    public function getProducts($category): MerchantProducts
    {
        $xmlContent = view('service.product.amazon.dummy.itemSearchResponse')->render();
        return (new ResponseParser())->parseProducts($xmlContent);
    }
}
