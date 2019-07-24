<?php

namespace App\Library\Services;

use App\Library\Interfaces\KongInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\HeaderBag;

class KongService implements KongInterface
{
    protected $client;
    protected $config;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->config = $this->getConfig();
    }

    public function getConfig()
    {
        return collect(config('kong'));
    }

    public function oauth2Token(string $authenticatedUserId)
    {
        $headers = $this->getHeaderCollection(request()->headers);

        return $this->client->request('POST', '/api/v1/users/oauth2/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Host' => $headers->get("x-forwarded-host") ?? $headers->get("host"),
            ],
            'form_params' => [
                'client_id' => $this->config->get('client_id'),
                'client_secret' => $this->config->get('client_secret'),
                'grant_type' => $this->config->get('grant_type')['authorize'],
                'provision_key' => $this->config->get('provision_key'),
                'authenticated_userid' => $authenticatedUserId,
                'scope' => $this->config->get('scope'),
            ],
        ]);
    }

    public function oauth2RefreshToken(string $refreshToken)
    {
        $headers = $this->getHeaderCollection(request()->headers);

        return $this->client->request('POST', '/api/v1/users/oauth2/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Host' => $headers->get("x-forwarded-host") ?? $headers->get("host"),
            ],
            'form_params' => [
                'client_id' => $this->config->get('client_id'),
                'client_secret' => $this->config->get('client_secret'),
                'grant_type' => $this->config->get('grant_type')['refresh_token'],
                'provision_key' => $this->config->get('provision_key'),
                'refresh_token' => $refreshToken,
                'scope' => $this->config->get('scope'),
            ],
        ]);
    }

    public function oauth2Revoke()
    {
        $headers = $this->getHeaderCollection(request()->headers);
        dd($headers);
        $token = $headers->get('x-authenticated-userid');

        return $this->client->request('DELETE', "/api/v1/users/oauth2_token/{$token}", [
            'headers' => [
                'Accept' => 'application/json',
                'Host' => $headers->get("x-forwarded-host") ?? $headers->get("host"),
            ],
            'form_params' => [
                'client_id' => $this->config->get('client_id'),
                'client_secret' => $this->config->get('client_secret'),
                //'grant_type' => $this->config->get('grant_type')['authorize'],
                'provision_key' => $this->config->get('provision_key'),
                'authenticated_userid' => $headers->get('x-authenticated-userid'),
                'scope' => $this->config->get('scope'),
            ],
        ]);
    }

    public function getHeaderCollection(HeaderBag $headers)
    {
        $headerNames = $headers->keys();

        return collect(array_reduce($headerNames, function ($carry, $headerName) use ($headers) {
            return Arr::add($carry, $headerName, $headers->get($headerName));
        }, []))
            ->except('content-length', 'content-type');
    }
}
