<?php

namespace TextProbe\Validator\Finance\Currency;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator that accepts only ISO-4217 currency codes.
 */
class ISO4217WhitelistValidator implements IValidator
{
    private const ISO4217_CODES = [
        'USD', 'EUR', 'GBP', 'CHF', 'JPY', 'CNY', 'RUB', 'RUR', 'UAH', 'KZT', 'BYN', 'TRY',
        'CAD', 'AUD', 'NZD', 'SGD', 'HKD', 'TWD', 'KRW', 'THB', 'VND', 'MYR', 'IDR', 'PHP',
        'INR', 'AED', 'SAR', 'QAR', 'KWD', 'BHD', 'NOK', 'SEK', 'DKK', 'PLN', 'CZK', 'HUF',
        'RON', 'BGN', 'HRK', 'RSD', 'GEL', 'AZN', 'AMD', 'MDL', 'ILS', 'MXN', 'BRL', 'ARS',
        'CLP', 'COP', 'PEN', 'ZAR', 'NGN', 'KES', 'GHS',
    ];

    public function validate(string $raw): bool
    {
        $code = strtoupper($raw);

        if (preg_match('/^[A-Z]{3}$/', $code) !== 1) {
            return false;
        }

        return in_array($code, self::ISO4217_CODES, true);
    }
}
