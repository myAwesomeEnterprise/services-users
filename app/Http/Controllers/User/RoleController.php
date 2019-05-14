<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\AbilityRequest;
use App\Http\Requests\Role\UserRequest;
use App\Http\Resources\Role as RoleResource;
use Illuminate\Http\Request;
use Silber\Bouncer\Bouncer;

class RoleController extends Controller
{
    public function get(User $user)
    {
        $roles = $user->roles;

        return RoleResource::collection($roles);
    }

    public function store(StoreRequest $request)
    {
        $role = Bouncer::role()->firstOrCreate($request->only('name', 'title'));

        return new RoleResource($role, 201);
    }

    public function ability(AbilityRequest $request)
    {
        if ($request->allow) {
            Bouncer::allow($request->role)->to($request->ability);
        } else {
            Bouncer::disallow($request->role)->to($request->ability);
        }

        return response()->json(null, 204);
    }

    public function user(UserRequest $request)
    {
        $user = User::where('uuid', $request->user)->first();

        if ($request->assign) {
            $user->assign($request->role);
        } else {
            $user->retract($request->role);
        }

        return response()->json(null, 204);
    }
}
