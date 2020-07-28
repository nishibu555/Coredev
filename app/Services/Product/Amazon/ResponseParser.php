<?php


namespace App\Services\Product\Amazon;


use App\Services\Product\MerchantProduct;
use App\Services\Product\MerchantProducts;
use Illuminate\Support\Facades\Log;

class ResponseParser
{
    public function parseProducts(string $xmlContent): MerchantProducts
    {
        $xml = new \DOMDocument();
        $xml->loadXML($xmlContent);

        if ((boolean)$xml->getElementsByTagName('ItemSearchResponse')->length) {
            $merchantProducts = new MerchantProducts([]);
            $products = $xml->getElementsByTagName("Items")[0];
            foreach ($products->getElementsByTagName("Item") as $product) {
                $ItemAttributes = $product->getElementsByTagName("ItemAttributes")[0];
                $image = $product->getElementsByTagName("MediumImage")[0];

                $merchantProduct = new MerchantProduct();
                $merchantProduct->setReference($product->getElementsByTagName("ASIN")[0]->nodeValue);
                $merchantProduct->setName($ItemAttributes->getElementsByTagName("Title")[0]->nodeValue);
                $merchantProduct->setCategory($ItemAttributes->getElementsByTagName('ProductGroup')[0]->nodeValue);
                $merchantProduct->setImageUrl($image->getElementsByTagName('URL')[0]->nodeValue);
                $merchantProduct->setProvider('amazon');

                $merchantProducts->push($merchantProduct);
            }

            return $merchantProducts;
        }

        $errorMessage = $xml->getElementsByTagName('ItemSearchErrorResponse')->item('0')->nodeValue;
        Log::error("[" . __METHOD__ . "] No product found. Error: $errorMessage");
        return new MerchantProducts([]);
    }
}
