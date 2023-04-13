<?php
/**
 * It will be helpful when you won't use any package
 * package like money or geoip
 */
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class CurrencyHelper
{
    public static function convert($amount, $fromCurrency = 'USD', $toCurrency = 'USD')
    {
        if ($fromCurrency !== $toCurrency) {
            $response = Http::get("https://openexchangerates.org/api/convert/{$amount}/{$fromCurrency}/{$toCurrency}", [
                'app_id' => env('OPENEXCHANGE_APP_ID')
            ]);
            $result = $response->json();
            if (isset($result['result'])) {
                return $result['result'];
            }
        }
        return $amount;
    }
}
