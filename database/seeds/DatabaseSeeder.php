<?php

use Illuminate\Database\Seeder;
use App\Crypto\CryptoService;
use App\Crypto\Coin;
use App\Crypto\Source;


class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Coin::truncate();       
        Source::truncate();
        
        $coinNames = [
            '1' => 'bitcoin',
            '2' => 'ethereum',
            '3' => 'ripple',
            '4' => 'litecoin',
            '5' => 'neo'
        ];

        $sources = [
            'coincap.io'        => 'https://api.coincap.io/v2/assets/',
            'coinmarketcap.com' => 'https://api.coinmarketcap.com/v1/ticker/',
        ];        

       $indexes = [

            'coincap.io' => [
                'price_key' => 'priceUsd',
                '24h_key' => 'changePercent24Hr'
            ],

            'coinmarketcap.com' => [
                'price_key' => 'price_usd',
                '24h_key' => 'percent_change_24h'
            ]
        ];

       foreach ($coinNames as $name) {
            DB::table('coins')->insert([
                'name' => $name,
            ]);
        }


        foreach ($sources as $source => $base_url) {

            $id = DB::table('sources')->insertGetId([
                'name' => $source,
                'base_url' => $base_url,
                'price_key' => $indexes[$source]['price_key'],
                'change24h_key' => $indexes[$source]['24h_key']
            ]);


            foreach ($coinNames as $coinId => $coinName) {

                DB::table('coin_metas')->insert([
                    'coin_id' => $coinId,
                    'source_id' => $id,
                    'api_slug' => $coinName
                ]);
            }
        }

        exec('php artisan get-crypto-info');
    }
}
