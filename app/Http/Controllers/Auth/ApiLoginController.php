<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Requests\User\ApiLoginRequest;
use App\Http\Controllers\Controller;
use App\Library\Interfaces\KongInterface;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends Controller
{
    public function login(ApiLoginRequest $request, KongInterface $kong)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $user = User::where('email', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            $response = $kong->oauth2Token($user->uuid);
            dd($response);
        }

        return response()->json([
            "message" => "The given credentials was invalid"
        ], 422);
    }
}
