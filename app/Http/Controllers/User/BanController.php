<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Events\AccountBaned;
use App\Events\AccountUnBan;
use App\Http\Requests\User\BanRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * BanController constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @param BanRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function ban(BanRequest $request, User $user)
    {
        $days = $request->get('days');

        $this->userRepository->ban($user, $days);

        event(new AccountBaned($user));
        fire('rabbit.echo', [['days' => $days]]);

        return response()->json([
            "message" => "The account has been banned"
        ], 200);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function unBan(User $user)
    {
        $this->userRepository->unBan($user);

        event(new AccountUnBan($user));

        return response()->json([
            "message" => "The account has been unbanned"
        ], 200);
    }
}
