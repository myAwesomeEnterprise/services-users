<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Requests\User\ApiLoginRequest;
use App\Http\Controllers\Controller;
use App\Library\Interfaces\KongInterface;
use App\Repositories\UserRepository;

class ApiLoginController extends Controller
{
    public function login(ApiLoginRequest $request, KongInterface $kong, UserRepository $userRepo)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = User::where('email', $username)->first();

        if (!($user && $userRepo->checkPassword($password, $user))) {
            return response()->json([
                "message" => "The given credentials was invalid"
            ], 401);
        }

        if ($userRepo->isVerified($user)) {
            return response()->json([
                'message' => 'Account not verified'
            ], 403);
        }

        if ($userRepo->isBanned($user)) {
            return response()->json([
                'message' => 'Account banned'
            ], 403);
        }

        $kongResponse = $kong->oauth2Token($user->uuid);

        if ($kongResponse->getStatusCode() === 200) {
            $body = json_decode($kongResponse->getBody()->getContents());
            $body->uuid = $user->uuid;

            return response()->json($body);
        }

        // TODO: response for errors
        return response()->json(null, 422);
    }
}
