<?php

namespace TextProbe\Validator\Finance\Price;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for price-like strings containing numeric amounts and currencies.
 *
 * The validator ensures that a matched fragment contains either a currency
 * symbol or a known 3-letter currency code (including slash-separated
 * alternatives), while also requiring at least one digit in the amount part.
 */
class PriceValidator implements IValidator
{
    private const KNOWN_CURRENCY_CODES = [
        'USD', 'EUR', 'GBP', 'CHF', 'JPY', 'CNY', 'RUB', 'RUR', 'UAH', 'KZT', 'BYN', 'TRY',
        'CAD', 'AUD', 'NZD', 'SGD', 'HKD', 'TWD', 'KRW', 'THB', 'VND', 'MYR', 'IDR', 'PHP',
        'INR', 'AED', 'SAR', 'QAR', 'KWD', 'BHD', 'NOK', 'SEK', 'DKK', 'PLN', 'CZK', 'HUF',
        'RON', 'BGN', 'HRK', 'RSD', 'GEL', 'AZN', 'AMD', 'MDL', 'ILS', 'MXN', 'BRL', 'ARS',
        'CLP', 'COP', 'PEN', 'ZAR', 'NGN', 'KES', 'GHS',
    ];

    public function validate(string $raw): bool
    {
        if (preg_match('/\d/u', $raw) === false) {
            return false;
        }

        $hasSymbol = preg_match('/[$€£¥₽₴₹₺₼₾₫₦₵₲₱฿₸₡₨]/u', $raw) === 1;

        if (preg_match('/[A-Z]{3}(?:\/[A-Z]{3})*/i', $raw, $match) !== 1) {
            return $hasSymbol;
        }

        $codes = explode('/', strtoupper($match[0]));

        foreach ($codes as $code) {
            if (!in_array($code, self::KNOWN_CURRENCY_CODES, true)) {
                return $hasSymbol;
            }
        }

        return true;
    }
}
