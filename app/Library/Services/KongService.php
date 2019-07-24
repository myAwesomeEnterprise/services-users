<?php

namespace App\Library\Services;

use App\Library\Interfaces\Oauth2Interface;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\HeaderBag;

class KongService implements Oauth2Interface
{
    protected $client;
    protected $config;

    private $tokenUri           = '/api/v1/users/oauth2/token';
    private $refreshTokenUri    = '/api/v1/users/oauth2/token';
    private $revoke             = '/oauth2_tokens';

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->config = $this->getConfig();
    }

    public function token(string $authenticatedUserId)
    {
        $params = $this->getBody('authorize');
        $params['authenticated_userid'] = $authenticatedUserId;

        return $this->request('POST', $this->tokenUri, $params);
    }

    public function refreshToken(string $refreshToken)
    {
        $params = $this->getBody('refresh_token');
        $params['refresh_token'] = $refreshToken;

        return $this->request('POST', $this->refreshTokenUri, $params);
    }

    public function revoke()
    {
        $token = $this->getAuthorizationToken();

        return $this->request('DELETE', "{$this->revoke}/{$token}");
    }

    private function getConfig()
    {
        return collect(config('kong'));
    }

    private function getHeaders()
    {
        $headers = $this->getHeaderCollection(request()->headers);

        return [
            'Host' => $headers->get("x-forwarded-host") ?? $headers->get("host"),
            'Authorization' => $headers->get('authorization'),
        ];
    }

    private function getAuthorizationToken()
    {
        $headers = $this->getHeaderCollection(request()->headers);

        return str_replace('Bearer ', '', $headers->get('authorization'));
    }

    private function getBody(string $grantType): array
    {
        return [
            'provision_key' => $this->config->get('provision_key'),
            'client_id' => $this->config->get('client_id'),
            'client_secret' => $this->config->get('client_secret'),
            'grant_type' => $this->config->get('grant_type')[$grantType],
            'scope' => $this->config->get('scope'),
        ];
    }

    private function request(string $method, string $uri, array $params = [])
    {
        return $this->client->request($method, $uri, [
            'headers' => $this->getHeaders(),
            'form_params' => $params,
        ]);
    }

    private function getHeaderCollection(HeaderBag $headers)
    {
        $headerNames = $headers->keys();

        return collect(array_reduce($headerNames, function ($carry, $headerName) use ($headers) {
            return Arr::add($carry, $headerName, $headers->get($headerName));
        }, []))
            ->except('content-length', 'content-type');
    }
}
