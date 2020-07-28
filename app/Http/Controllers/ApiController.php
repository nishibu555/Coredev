<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function check(Request $request)
    {
        return response()->json(
            [
                'version' => '1.0.0',
                'message' => 'Welcome to Giftype API',
                'data' => [
                    'accessed_from' => $request->getClientIp(),
                    'accessed_at' => now()->format('Y-m-d H:i:s'),
                    'is_authenticated' => auth('api')->check(),
                ]
            ]
        );
    }
}
