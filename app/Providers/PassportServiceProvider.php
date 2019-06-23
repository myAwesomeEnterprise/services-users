<?php

namespace App\Providers;

use App\Auth\BearerTokenResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Laravel\Passport\Bridge;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\PassportServiceProvider as PassportProvider;

class PassportServiceProvider extends PassportProvider
{
    /**
     * Make the authorization service instance.
     *
     * @return AuthorizationServer
     * @throws BindingResolutionException
     */
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(Bridge\ClientRepository::class),
            $this->app->make(Bridge\AccessTokenRepository::class),
            $this->app->make(Bridge\ScopeRepository::class),
            $this->makeCryptKey('private'),
            app('encrypter')->getKey(),
            new BearerTokenResponse()
        );
    }
}
