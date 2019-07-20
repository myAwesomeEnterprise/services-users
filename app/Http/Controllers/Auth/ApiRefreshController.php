<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\User\RefreshTokenRequest;
use App\Library\Interfaces\KongInterface;
use App\Http\Controllers\Controller;

class ApiRefreshController extends Controller
{
    public function refresh(RefreshTokenRequest $request, KongInterface $kong)
    {
        $response = $kong->oauth2RefreshToken($request->get('refresh_token'));

        if ($response->getStatusCode() === 200) {
            $body = json_decode($response->getBody()->getContents());

            return response()->json($body);
        }

        // TODO: response for errors
        return response()->json(null, 422);
    }
}
