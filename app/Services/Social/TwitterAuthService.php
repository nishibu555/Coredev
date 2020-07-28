<?php


namespace App\Services\Social;



use GuzzleHttp\Client;

class TwitterAuthService
{
    public $consumerKey;
    public $consumerSecret;
    public $redirectUri;
    protected $requestTokenUrl = 'https://api.twitter.com/oauth/request_token';

    public function __construct($consumerKey, $consumerSecret, $redirectUri)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->redirectUri = $redirectUri;
    }

    public function getRequestToken()
    {
        $oauthParams = $this->getOauthParam();
        $baseString = $this->buildBaseString($this->requestTokenUrl, $oauthParams);
        $compositeKey = $this->getCompositeKey($this->consumerSecret, null); // first request, no request token yet
        $oauthParams['oauth_signature'] = $this->makeOauthSignature($baseString, $compositeKey); // sign the base string

        $access = $this->sendRequest($this->requestTokenUrl, $oauthParams);
        $arrays = explode('&', $access);
        $access = [];
        foreach ($arrays as $array) {
            $values = explode('=', $array);
            $access[$values[0]] = $values[1];
        }
        return $access;
    }

    public function getAccessToken($params)
    {
        $client = new Client();

        $query = 'oauth_token='.$params['oauth_token'].'&oauth_verifier='.$params['oauth_verifier'];
        $options = [
            'form_params' => [
                'oauth_token' => $params['oauth_token'],
                'oauth_verifier' => $params['oauth_verifier']
            ]
        ];
        $response = $client->post('https://api.twitter.com/oauth/access_token?'.$query);
        $access = $response->getBody()->getContents();
        $arrays = explode('&', $access);
        $access = [];
        foreach ($arrays as $array) {
            $values = explode('=', $array);
            $access[$values[0]] = $values[1];
        }
        return $access;
    }

    public function sendRequest($url, $oauthParams)
    {
        $client = new Client();
        $options = [
            'headers' => [
                'Authorization' => $this->buildAuthorizationHeader($oauthParams)
            ]];
        $response = $client->post($url, $options);
        return $response->getBody()->getContents();
    }

    public function getOauthParam()
    {
        return [
            'oauth_callback' => $this->redirectUri,
            'oauth_consumer_key' => $this->consumerKey,
            'oauth_nonce' => md5(uniqid()),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
        ];
    }

    protected function makeOauthSignature($baseString, $compositeKey)
    {
        return base64_encode(hash_hmac(
            'sha1',
            $baseString,
            $compositeKey,
            true
        ));
    }

    protected  function getCompositeKey($consumerSecret, $requestToken)
    {
        return rawurlencode($consumerSecret) . '&' . rawurlencode($requestToken);
    }

    protected function buildBaseString($baseURI, $oauthParams)
    {
        $baseStringParts = [];
        ksort($oauthParams);
        foreach ($oauthParams as $key => $value) {
            $baseStringParts[] = "$key=" . rawurlencode($value);
        }
        return 'POST&' . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $baseStringParts));
    }

    protected function buildAuthorizationHeader($oauthParams)
    {
        $authHeader = 'OAuth ';
        $values = [];
        foreach ($oauthParams as $key => $value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        $authHeader .= implode(', ', $values);
        return $authHeader;
    }

}
