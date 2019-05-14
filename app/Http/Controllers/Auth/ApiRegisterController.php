<?php

namespace App\Http\Controllers\Auth;

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

        event(new Registered($user = $this->create($request->all())));

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
    }
}
