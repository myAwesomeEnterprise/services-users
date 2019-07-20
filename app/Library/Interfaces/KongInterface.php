<?php

namespace App\Library\Interfaces;

use GuzzleHttp\Client;

interface KongInterface
{
    /**
     * KongInterface constructor.
     * @param Client $client
     */
    public function __construct(Client $client);

    /**
     * @param string $authenticatedUserId
     * @return mixed
     */
    public function oauth2Token(string $authenticatedUserId);

    /**
     * @param string $refreshToken
     * @return mixed
     */
    public function oauth2RefreshToken(string $refreshToken);

    /**
     * @param string $username
     * @param string $custom_id
     * @param array $tags
     * @return mixed
     */
    public function createConsumer(string $username, string $custom_id, array $tags = []);
}
