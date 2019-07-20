<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

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
     * @param UserRepository $userRepo
     * @return JsonResponse
     */
    public function deactivate(User $user, UserRepository $userRepo)
    {
        $userRepo->unVerify($user);

        return response()->json([
            "message" => "The account has been deactivated"
        ], 200);
    }

    /**
     * @param User $user
     * @param UserRepository $userRepo
     * @return JsonResponse
     */
    public function activate(User $user, UserRepository $userRepo)
    {
        $userRepo->verify($user);

        return response()->json([
            "message" => "The account has been activated"
        ], 200);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function sendEmail(User $user)
    {
        $user->sendEmailVerificationNotification();

        return response()->json([
            "message" => "The activation email has been send",
        ], 200);
    }
}
