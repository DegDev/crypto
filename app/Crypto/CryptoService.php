<?php

namespace App\Crypto;

use App\Crypto\Crypto;
use App\Crypto\Coin;
use App\Crypto\Source;
use App\Crypto\Events\TickerUpdated;

class CryptoService
{

    protected $crypto;
    protected $coin;
    protected $source;

    public function __construct(Crypto $crypto, Coin $coin, Source $source)
    {
        $this->crypto = $crypto;
        $this->coin   = $coin;
        $this->source = $source;
    }
    /**
     * Parse all sources and return result array
     *
     * @return array
     */
    public function parseAllSources()
    {
        $coins = $this->coin->all();

        $sources = $this->source->all();

        $sourceCount = $sources->count();

        foreach ($coins as $coin) {

            $priceTotal = 0;

            $change24hTotal = 0;

            foreach ($sources as $source) {

                $recievedData = $this->parse($source, $coin->name);

                // Possible improvement: Add Validation for $recievedData
                // 'price' and 'change24hTotal' have to be float
                $priceTotal += $recievedData['price'];

                $change24hTotal += $recievedData['change24hTotal'];
            }

            $result[] = [
                'coin_id' => $coin->id,
                'name' => $coin->name,
                'avg_price' => round($priceTotal / $sourceCount, 2),
                'Change(24h)' => round($change24hTotal / $sourceCount, 3)
            ];
        }

        return $result;
    }
    /**
     *  Request data from $url
     *
     * @return array
     */
    private function getApiData($url)
    {

        $json = file_get_contents($url);

        $coinData = json_decode($json, true);

        if (is_array($coinData)) {

            $coinData = array_shift($coinData);
        }

        return $coinData;
    }
    /**
     *  Parse Source and get needed data
     *
     * @return array
     */
    private function parse(Source $source, $slug)
    {
        $data = [];

        $url = $source->base_url.$slug;

        $coinData = $this->getApiData($url);

        $data['price'] = $coinData[$source->price_key];

        $data['change24hTotal'] = $coinData[$source->change24h_key];

        return $data;
    }
    /**
     *  Run CryptoService:
     * 1. Parse data from allSources
     * 2. Filter only fresh data
     * 3. Broadcast filtered data
     *
     * Only New actual data get saved into Database and broadcasted to all clients
     *
     * @return bool
     */
    public function run()
    {
        $recievedData = $this->parseAllSources();

        $filteredData = [];

        foreach ($recievedData as $data) {

            if ($this->crypto->isFresh($data)) {

                $this->crypto->store($data);

                $filteredData[] = $data;
            }
        }

        if (!empty($filteredData)) {

            TickerUpdated::dispatch($filteredData);
        }

        return true;
    }
}