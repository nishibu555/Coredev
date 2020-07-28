<?php

namespace App\Services\Feed;

use App\Exceptions\ApiException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class FeedApiService
{
    protected $url;
    protected $config;

    public function __construct($config)
    {
        $this->url    = $config['url'];
        $this->credentials = Arr::only($config, ['username', 'password']);
    }

    /**
     * Make a Get request
     *
     * @param $path
     * @param array $params
     * @return mixed
     * @throws ApiException
     */
    public function get($path, $params = [])
    {
        return $this->call('get', $path, $params);
    }

    /**
     * Make a POST request
     *
     * @param $path
     * @param array $params
     * @return mixed
     * @throws ApiException
     */
    public function post($path, $params = [])
    {
        return $this->call('post', $path, $params);
    }

    protected function call($method, $path, $params = [])
    {
        $url    = $this->url . $path;

        $method = strtolower($method);
        $client = new Client();

        // options
        $field = Arr::get([
            'post' => 'form_params',
            'put'  => 'json',
        ], $method, $params);

        // log
        Log::info(print_r($url, 1));
        Log::info(print_r($field, 1));

        // -------------------------------------------------------------------------------------------------------------
        // API CALL
        // -------------------------------------------------------------------------------------------------------------
        try{
            $output = '';
            if(empty($url)) {
                throw new ApiException('Feed api url not set to the environment file. Please check');
            }
            $response = $client->request($method, $url, $field);
        }
        catch (RequestException $e){
            $response = $e->getResponse();
        }

        if ($response && $response->getBody()) {
            $output   = $response->getBody()->getContents();
        }

        try{
            $data = json_decode($output);
        }
        catch (Exception $e){
            throw new ApiException($e->getMessage(), $output);
        }

        return $data;
    }
}
