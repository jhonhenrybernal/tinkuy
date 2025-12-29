<?php

use App\Models\Currency;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('convert_price')) {
    function convert_price($amount, $currencyCode = null)
    {
        $currencyCode = $currencyCode ?: session('currency', getWebConfig('default_currency', 'USD'));

        $usdExchangeRate = Cache::rememberForever('currency_USD', function () {
            return Currency::where('code', 'USD')->value('exchange_rate') ?: 1.0;
        });

        $targetExchangeRate = Cache::rememberForever("currency_{$currencyCode}", function () use ($currencyCode) {
            return Currency::where('code', $currencyCode)->value('exchange_rate') ?: 1.0;
        });

        return round($amount * ($targetExchangeRate / $usdExchangeRate), 2);
    }
}

if (! function_exists('currency_to_usd')) {
    function currency_to_usd($amount, $fromCurrency)
    {
        $usdRate = Currency::where('code', 'USD')->value('exchange_rate') ?: 1.0;
        $fromRate = Currency::where('code', $fromCurrency)->value('exchange_rate') ?: 1.0;

        return round($amount * ($usdRate / $fromRate), 2);
    }
}

if (! function_exists('getWebConfig')) {
    function getWebConfig($key, $default = null)
    {
        return Cache::rememberForever("store_setting_{$key}", function () use ($key, $default) {
            return StoreSetting::where('key', $key)->value('value') ?? $default;
        });
    }
}

if (! function_exists('activeCurrency')) {
    function activeCurrency()
    {
        return Cache::rememberForever('active_currency_'.session('currency', 'USD'), function () {
            return Currency::where('code', session('currency', 'USD'))->first();
        });
    }
}
