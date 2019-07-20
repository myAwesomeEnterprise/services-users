<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ApiRegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class ApiRegisterController extends Controller
{
    public function register(ApiRegisterRequest $request)
    {
        $user = User::create([
            'uuid' => Uuid::uuid4(),
            'name' =>$request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        fire('users.registered', [['user_id' => $user]]);

        return new UserResource($user);
    }
}
