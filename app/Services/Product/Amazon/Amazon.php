<?php

namespace App\Services\Product\Amazon;

use App\Services\Product\Merchant;
use App\Services\Product\MerchantProducts;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Amazon extends Merchant
{
    private $credentials;
    private $responseGroup;
    private $operation;
    private $service;
    private $isDummy = true;

    public function __construct(
        array $credentials,
        string $responseGroup,
        string $operation,
        string $service = 'AWSECommerceService'
    ) {
        $this->credentials = $credentials;
        $this->responseGroup = $responseGroup;
        $this->operation = $operation;
        $this->service = $service;
    }

    public function setResponseGroup(string $responseGroup): void
    {
        $this->responseGroup = $responseGroup;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    public function setService(string $service): void
    {
        $this->service = $service;
    }

    public function setIsDummy(bool $isDummy)
    {
        $this->isDummy = $isDummy;
    }

    public function getProducts($category): MerchantProducts
    {
        if ($this->isDummy) {
            return (new DummyAmazon())->getProducts($category);
        }

        //Credentials
        $queryParams['Service'] = $this->credentials['service'];
        $queryParams['AWSAccessKeyId'] = $this->credentials['key'];
        $queryParams['AssociateTag'] = $this->credentials['associate_tag'];

        $queryParams['Operation'] = $this->operation;
        $queryParams['ResponseGroup'] = $this->responseGroup;
        $queryParams['Timestamp'] = urlencode(gmdate("Y-m-d\TH:i:s\Z"));
        $queryParams['Signature'] = $this->getSignature($queryParams);

        $queryParams['SearchIndex'] = $category;

        $url = "http://webservices.amazon.com/onca/xml?" . http_build_query($queryParams);

        $client = new Client();
        $request = $client->get($url);
        $result = $request->getBody();

        return (new ResponseParser())->parseProducts($result);
    }

    private function getSignature(array $queryParams): string
    {
        natsort($queryParams);

        $signatureString = "GET\nwebservices.amazon.com\n/onca/xml\n";

        $signatureString .= implode("&", $queryParams);

        return base64_encode(hash_hmac(
            "sha256",
            $signatureString,
            $this->credentials['secret'],
            true
        ));
    }
}
