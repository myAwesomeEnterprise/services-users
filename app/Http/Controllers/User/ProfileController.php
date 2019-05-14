<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Http\Requests\User\ProfileUpdatePasswordRequest;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function get(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, ProfileUpdateRequest $request)
    {
        $user->update($request->only('name', 'email'));

        return new UserResource($user);
    }

    public function updatePassword(User $user, ProfileUpdatePasswordRequest $request)
    {
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(null, 204);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
