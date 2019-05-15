<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('verify');
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(User $user)
    {
        $user->email_verified_at = null;
        $user->save();

        return response()->json([
            "message" => "The account has been deactivated"
        ], 200);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(User $user)
    {
        $user->email_verified_at = Carbon::now();
        $user->save();

        return response()->json([
            "message" => "The account has been activated"
        ], 200);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(User $user)
    {
        $user->sendEmailVerificationNotification();

        return response()->json([
            "message" => "The activation email has been send",
        ], 200);
    }
}
