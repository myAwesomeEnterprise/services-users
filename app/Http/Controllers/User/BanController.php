<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Requests\User\BanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    public function ban(BanRequest $request, User $user)
    {
        $days = $request->get('days');

        $user->ban = true;
        $user->banned_until = $days > 0 ? now()->addDays($days) : null;
        $user->save();

        return response()->json([
            "message" => "The account has been banned"
        ], 200);
    }

    public function unban(User $user)
    {
        $user->ban = false;
        $user->banned_until = null;
        $user->save();

        return response()->json([
            "message" => "The account has been unbanned"
        ], 200);
    }
}
