<?php

use Illuminate\Support\Facades\Request;
use Torann\GeoIP\Facades\GeoIP;
use App\Services\CurrencyConverter;
/**
 * Get the currency code for the user's location
 */
function getUserCurrencyCode()
{
    // Get the user's IP address
    $ip = Request::ip();

    // Get the user's country
    $country = GeoIP::getLocation($ip)->getAttribute('country');

    // Map the country to a currency code
    $currencyMap = [
        'US' => 'USD',
        'CA' => 'CAD',
        'GB' => 'GBP',
        'BD' => 'BDT',
        'FR' => 'EUR',
        // Add more country/currency mappings as needed
    ];

    $currencyCode = $currencyMap[$country] ?? 'USD';

    return $currencyCode;
}

/**
 * Format a price in the user's currency
 */
function formatPrice($price)
{
    $currencyCode = getUserCurrencyCode();
    $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
    $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currencyCode);
    $floatPrice = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); // convert to float value
    return $formatter->formatCurrency($floatPrice, $currencyCode);
}

function convertCurrency($amount, $toCurrency) {
    $fromCurrency = getUserCurrencyCode();
    $currencyConverter = app(CurrencyConverter::class);
    return $currencyConverter->convert($amount, $fromCurrency, $toCurrency);
}

