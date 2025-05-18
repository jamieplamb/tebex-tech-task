<?php

namespace App\Providers;

use App\Contracts\LookupFactoryInterface;
use App\Services\PlatformLookupFactory;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LookupServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(LookupFactoryInterface::class, function ($app) {
            return new PlatformLookupFactory(new Client());
        });
    }
}
