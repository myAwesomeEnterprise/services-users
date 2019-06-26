<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\AbilityRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Requests\Role\UserRequest;
use App\Http\Resources\Ability as AbilityResource;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\User as UserResource;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
    public function all()
    {
        $roles = Role::paginate();

        return RoleResource::collection($roles);
    }

    public function store(StoreRequest $request)
    {
        $role = Bouncer::role()->firstOrCreate($request->only('name', 'title'));

        return new RoleResource($role);
    }

    public function get(Role $role)
    {
        return new RoleResource($role);
    }

    public function update(Role $role, UpdateRequest $request)
    {
        $role->update($request->all());

        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, 204);
    }

    public function ability(Role $role, AbilityRequest $request)
    {
        if ($request->allow) {
            Bouncer::allow($role)->to($request->ability);
        } else {
            Bouncer::disallow($role)->to($request->ability);
        }

        return response()->json(null, 204);
    }

    public function abilities(Role $role)
    {
        $abilities = $role->abilities()->paginate();

        return AbilityResource::collection($abilities);
    }

    public function getRolesOfUser(User $user)
    {
        $roles = $user->roles;

        return RoleResource::collection($roles);
    }

    public function assignUser(UserRequest $request)
    {
        $user = User::where('uuid', $request->user)->first();

        if ($request->assign) {
            $user->assign($request->role);
        } else {
            $user->retract($request->role);
        }

        return response()->json(null, 204);
    }

    public function users(Role $role)
    {
        $users = $role->users()->paginate();

        return UserResource::collection($users);
    }
}
