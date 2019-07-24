<?php

namespace App\Library\Interfaces;

use GuzzleHttp\Client;

interface Oauth2Interface
{
    /**
     * Oauth2Interface constructor.
     * @param Client $client
     */
    public function __construct(Client $client);

    /**
     * @param string $authenticatedUserId
     * @return mixed
     */
    public function token(string $authenticatedUserId);

    /**
     * @param string $refreshToken
     * @return mixed
     */
    public function refreshToken(string $refreshToken);

    /**
     * @return mixed
     */
    public function revoke();
}
