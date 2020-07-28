<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string|null $message
     * @param array $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json(string $message = null, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $content = [];
        if ($message) {
            $content['message'] = $message;
        }

        if (!empty($data)) {
            $content['data'] = $data;
        }

        return response()->json($content, $status, $headers, $options);
    }

    protected function responseJson(
        string $msg,
        string $redirectTo = '',
        int $statusCode = Response::HTTP_OK,
        array $headers = []
    ) {
        if ($statusCode == Response::HTTP_OK) {
            session()->flash('success', $msg);
        } else {
            session()->flash('error', $msg);
        }

        return response()->json(
            [
                'message' => $msg,
                'redirect_url' => $redirectTo,
            ],
            $statusCode,
            $headers
        );
    }
}
