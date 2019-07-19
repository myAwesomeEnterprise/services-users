<?php

namespace App\Providers;

use App\Library\Interfaces\KongInterface;
use App\Library\Services\KongService;
use \GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class KongServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerKong(
            $this->getClient()
        );
    }

    public function registerKong($client)
    {
        $this->app->bind(KongInterface::class, function ($app) use ($client) {
            return new KongService($client);
        });
    }

    public function getClient()
    {
        $config = $this->app->config['kong'];

        $scheme = $config['scheme'];
        $host = $config['host'];
        $port = $config['port'];
        $timeout = $config['timeout'];

        return new Client([
            'base_uri' => "{$scheme}://{$host}:{$port}",
            'timeout' => $timeout,
            'debug' => true,
        ]);
    }
}
