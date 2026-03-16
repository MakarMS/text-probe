<?php

namespace TextProbe\Validator\System;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validates W3C trace-id values.
 */
class W3cTraceIdValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $value = strtolower(trim($raw));

        if (preg_match('/^[0-9a-f]{32}$/', $value) !== 1) {
            return false;
        }

        return $value !== str_repeat('0', 32);
    }
}
