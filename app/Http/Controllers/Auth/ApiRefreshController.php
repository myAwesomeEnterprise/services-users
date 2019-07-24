<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\User\RefreshTokenRequest;
use App\Http\Controllers\Controller;
use App\Library\Interfaces\Oauth2Interface;

class ApiRefreshController extends Controller
{
    public function refresh(RefreshTokenRequest $request, Oauth2Interface $oauth2)
    {
        $response = $oauth2->refreshToken($request->get('refresh_token'));

        if ($response->getStatusCode() === 200) {
            $body = json_decode($response->getBody()->getContents());

            return response()->json($body);
        }

        // TODO: response for errors
        return response()->json(null, 422);
    }
}
