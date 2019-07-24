<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Library\Interfaces\Oauth2Interface;

class LogoutController extends Controller
{
    public function logout(Oauth2Interface $oauth2)
    {
        $oauth2->revoke();

        return response()->json([
            'message' => 'You are Logged out.',
        ], 200);
    }
}
