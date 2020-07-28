<?php

namespace Tests\Unit\Services\Product\Amazon;

use App\Services\Product\Amazon\DummyAmazon;
use App\Services\Product\MerchantProducts;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DummyAmazonTest extends TestCase
{

    public function testGetProducts()
    {
        $products = (new DummyAmazon())->getProducts('books');
        $this->assertInstanceOf(MerchantProducts::class, $products);
    }
}
