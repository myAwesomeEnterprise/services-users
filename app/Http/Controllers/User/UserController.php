<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $users = User::search($request->q)->paginate();

        return UserResource::collection($users);
    }

    public function all()
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function get(User $user)
    {
        return new UserResource($user);
    }

    public function store(User $user, UserStoreRequest $request)
    {
        $user = User::create([
            'uuid' => Uuid::uuid4(),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return new UserResource($user, 201);
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
