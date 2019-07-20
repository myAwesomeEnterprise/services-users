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
        $env = $this->app->config['app']['env'];

        return new Client([
            'base_uri' => $config['host'],
            'timeout' => $config['timeout'],
            'verify' => !($env === 'local'),
        ]);
    }
}
