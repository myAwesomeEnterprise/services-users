<?php

namespace App\Http\Controllers\User;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ability\StoreRequest;
use App\Http\Requests\Ability\UpdateRequest;
use App\Http\Requests\Ability\UserRequest;
use App\Http\Requests\Ability\ModelRequest;
use App\Http\Requests\Ability\EntityRequest;
use App\Http\Requests\Ability\EverythingRequest;
use App\Http\Requests\Ability\ManageModelRequest;
use App\Http\Requests\Ability\ManageEntityRequest;
use App\Http\Requests\Ability\OwnModelRequest;
use App\Http\Requests\Ability\OwnEverythingRequest;
use App\Http\Resources\Ability as AbilityResource;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\User as UserResource;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Silber\Bouncer\Database\Ability;

class AbilityController extends Controller
{
    public function all()
    {
        $abilities = Ability::paginate();

        return AbilityResource::collection($abilities);
    }

    public function store(StoreRequest $request)
    {
        $ability = Bouncer::ability()->firstOrCreate($request->only('name', 'title'));

        return new AbilityResource($ability, 201);
    }

    public function get(Ability $ability)
    {
        return new AbilityResource($ability);
    }

    public function update(Ability $ability, UpdateRequest $request)
    {
        $ability->update($request->all());

        return new AbilityResource($ability);
    }

    public function destroy(Ability $ability)
    {
        $ability->delete();

        return response()->json(null, 204);
    }

    public function roles(Ability $ability)
    {
        $roles = $ability->roles()->paginate();

        return RoleResource::collection($roles);
    }

    public function users(Ability $ability)
    {
        $users = $ability->users()->paginate();

        return UserResource::collection($users);
    }

    public function getAbilitiesOfUser(User $user)
    {
        $abilities = $user->getAbilities();

        return AbilityResource::collection($abilities);
    }

    public function user(UserRequest $request)
    {
        $user = User::uuid($request->user)->first();

        if ($request->allow) {
            $user->allow($request->ability);
        } else {
            $user->disallow($request->ability);
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->to($request->ability);
        } else {
            Bouncer::unforbid($user)->to($request->ability);
        }

        return response()->json(null, 204);
    }

    public function model(ModelRequest $request)
    {
        $user = User::uuid($request->user)->first();

        if ($request->allow) {
            $user->allow($request->ability, $request->model);
        } else {
            $user->disallow($request->ability, $request->model);
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->to($request->ability, $request->model);
        } else {
            Bouncer::unforbid($user)->to($request->ability, $request->model);
        }

        return response()->json(null, 204);
    }

    public function entity(EntityRequest $request)
    {
        $user = User::uuid($request->user)->first();

        $model = new $request->model;
        $entity = $model->findOrFail($request->entity);

        if ($request->allow) {
            $user->allow($request->ability, $entity);
        } else {
            $user->disallow($request->ability, $entity);
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->to($request->ability, $entity);
        } else {
            Bouncer::unforbid($user)->to($request->ability, $entity);
        }

        return response()->json(null, 204);
    }

    public function everything(EverythingRequest $request)
    {
        $user = User::uuid($request->user)->first();

        if ($request->allow) {
            Bouncer::allow($user)->everything();
        } else {
            Bouncer::disallow($user)->everything();
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->everything();
        } else {
            Bouncer::unforbid($user)->everything();
        }

        return response()->json(null, 204);
    }

    public function manageModel(ManageModelRequest $request)
    {
        $user = User::uuid($request->user)->first();

        if ($request->allow) {
            Bouncer::allow($user)->toManage($request->model);
        } else {
            Bouncer::disallow($user)->toManage($request->model);
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->toManage($request->model);
        } else {
            Bouncer::unforbid($user)->toManage($request->model);
        }

        return response()->json(null, 204);
    }

    public function manageEntity(ManageEntityRequest $request)
    {
        $user = User::uuid($request->user)->first();

        $model = new $request->model;
        $entity = $model->findOrFail($request->entity);

        if ($request->allow) {
            Bouncer::allow($user)->toManage($entity);
        } else {
            Bouncer::disallow($user)->toManage($entity);
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->toManage($entity);
        } else {
            Bouncer::unforbid($user)->toManage($entity);
        }

        return response()->json(null, 204);
    }

    public function ownModel(OwnModelRequest $request)
    {
        $user = User::uuid($request->user)->first();

        if ($request->allow) {
            Bouncer::allow($user)->toOwn($request->model);
        } else {
            Bouncer::disallow($user)->toOwn($request->model);
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->toOwn($request->model);
        } else {
            Bouncer::unforbid($user)->toOwn($request->model);
        }

        return response()->json(null, 204);
    }

    public function ownEverything(OwnEverythingRequest $request)
    {
        $user = User::uuid($request->user)->first();

        if ($request->allow) {
            Bouncer::allow($user)->toOwnEverything();
        } else {
            Bouncer::disallow($user)->toOwnEverything();
        }

        if ($request->forbid) {
            Bouncer::forbid($user)->toOwnEverything();
        } else {
            Bouncer::unforbid($user)->toOwnEverything();
        }

        return response()->json(null, 204);
    }
}
