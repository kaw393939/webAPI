<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Http\Middleware\BaseMiddleware as Middleware;

class BaseMiddleware extends Middleware
{

    public function checkForToken($request)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
             return response()->json([
                'success' => false,
                'message' => 'Sorry, no auth token found'
            ], 500);
        }
    }
}