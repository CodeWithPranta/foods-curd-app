<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrencyConverter
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.exchangeratesapi.io/',
        ]);
        $this->apiKey = env('EXCHANGE_RATES_API_KEY');
    }

    public function convert($amount, $fromCurrency, $toCurrency)
    {
        $response = $this->client->get('latest', [
            'query' => [
                'access_key' => $this->apiKey,
                'base' => $fromCurrency,
                'symbols' => $toCurrency,
            ],
        ]);
        $data = json_decode($response->getBody(), true);

        if ($data['success'] === false) {
            throw new \Exception($data['error']['info']);
        }

        $rate = $data['rates'][$toCurrency];
        $convertedAmount = $amount * $rate;

        return $convertedAmount;
    }
}
