<?php

namespace App\Crypto\Providers;

use App\Crypto\Crypto;
use App\Crypto\Coin;
use App\Crypto\Source;
use App\Crypto\CryptoService;

use Illuminate\Support\ServiceProvider;


class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CryptoService::class, function ($app) {

            $coin   = $this->app->make(Coin::class);
            
            $source = $this->app->make(Source::class);

            $crypto = $this->app->make(Crypto::class);
            

            return new CryptoService($crypto, $coin, $source);

        });
    }
}
