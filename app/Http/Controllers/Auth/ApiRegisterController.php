<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\User as UserResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class ApiRegisterController extends RegisterController
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        fire('users.registered', [['user_id' => $user]]);

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://kong:8001'
        ]);
        $response = $client->request('POST', '/consumers', [
            'form_params' => [
                'username' => $user->email,
                'custom_id' => $user->uuid->toString(),
            ]
        ]);

        return new UserResource($user);

        /*
        $client = Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $request->get('email'),
            'password'      => $request->get('password'),
            'scope'         => null,
        ]);

        $token = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($token);
        */
    }
}
