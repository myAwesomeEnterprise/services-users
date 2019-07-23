<?php

namespace App\Library\Services;

use App\Library\Interfaces\KongInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\HeaderBag;

class KongService implements KongInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function oauth2Token(string $authenticatedUserId)
    {
        $headers = $this->getHeaderCollection(request()->headers);
        $config = collect(config('kong'));

        return $this->client->request('POST', '/api/v1/users/oauth2/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Host' => $headers->get("x-forwarded-host") ?? $headers->get("host"),
            ],
            'form_params' => [
                'client_id' => $config->get('client_id'),
                'client_secret' => $config->get('client_secret'),
                'grant_type' => $config->get('grant_type')['authorize'],
                'provision_key' => $config->get('provision_key'),
                'authenticated_userid' => $authenticatedUserId,
                'scope' => $config->get('scope'),
            ],
        ]);
    }

    public function oauth2RefreshToken(string $refreshToken)
    {
        $headers = $this->getHeaderCollection(request()->headers);
        $config = collect(config('kong'));

        return $this->client->request('POST', '/api/v1/users/oauth2/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Host' => $headers->get("x-forwarded-host") ?? $headers->get("host"),
            ],
            'form_params' => [
                'client_id' => $config->get('client_id'),
                'client_secret' => $config->get('client_secret'),
                'grant_type' => $config->get('grant_type')['refresh_token'],
                'provision_key' => $config->get('provision_key'),
                'refresh_token' => $refreshToken,
                'scope' => $config->get('scope'),
            ],
        ]);
    }

    public function createConsumer(string $username, string $custom_id, array $tags = [])
    {
        return $this->client->request('POST', '/consumers', [
            'form_params' => [
                'username' => $username,
                'custom_id' => $custom_id,
                'tags' => $tags,
            ],
            'debug' => true,
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
