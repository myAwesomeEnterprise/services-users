<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Library\Interfaces\KongInterface;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(KongInterface $kong)
    {
        $kong->oauth2Revoke();

        return response()->json([
            'message' => 'You are Logged out.',
        ], 200);
    }
}
