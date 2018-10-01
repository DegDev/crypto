<?php

use App\Crypto\CryptoService;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


Artisan::command('get-crypto-info', function () {

 $cryptoService = app(CryptoService::class);

    if( $cryptoService->run()  ) {
        $this->comment('CryptoCurrencies has been updated: '.date('Y-m-d H:i:s'));
    }

})->describe('Update crypto currencies');
