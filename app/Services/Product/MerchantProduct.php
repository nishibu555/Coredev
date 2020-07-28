<?php

namespace App\Services\Product;

class MerchantProduct
{
    public $reference;
    public $name;
    public $category;
    public $imageUrl;
    public $provider;

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }
}
