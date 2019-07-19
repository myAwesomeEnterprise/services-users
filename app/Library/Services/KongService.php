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

        $body = $config->only(['client_id', 'client_secret', 'grant_type', 'provision_key', 'scope']) ?? collect();
        $body->put('authenticated_userid', $authenticatedUserId);

        return $this->client->request('POST', '/api/v1/users/oauth2/token', [
            'headers' => [
                'Host' => $headers->get("x-forwarded-host")
            ],
            'form_params' => $body->toArray()
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
