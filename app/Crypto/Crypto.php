<?php

namespace App\Crypto;

use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    public $timestamps = false;
    /**
     * Store data to database
     *
     *  @return void
     */
    public function store($data)
    {
        $coin            = new $this;
        $coin->coin_id   = $data['coin_id'];
        $coin->avg_price = $data['avg_price'];
        $coin->change24h = $data['Change(24h)'];
        $coin->save();
    }
    /**
     *  Check if recived data is fresh,
     *  returns false if data isnt updated and the same what stored in Database
     *
     *  @return string bool
     */
    public function isFresh($data)
    {

        $crypto = $this::where('coin_id', '=', $data['coin_id'])
            ->latest()
            ->first();
        
        if (!($crypto == null) &&
            ($crypto->avg_price == $data['avg_price']) &&
            ($crypto->change24h == $data['Change(24h)'])) {

            return false;
        }

        return true;
    }
    /**
     *  Select and return latests currenices
     *
     * @return App\Crypto\Crypto Collection
     */
    public function getLatestCurrencies(){

        return    $this->whereIn('id',function($query) {
                        $query->selectRaw('max(id)')->from('cryptos')->groupBy('coin_id');
                    })->get();
    }
    /**
     *
     * Get the cryptoStorageData that owns the coin.
     *
     */
    public function coin()
    {
        return $this->belongsTo('App\Crypto\Coin');
    }
}