<?php

namespace TextProbe\Validator\System;

use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Validates W3C span-id values.
 */
class W3cSpanIdValidator implements IValidator
{
    #[Override]
    public function validate(string $raw): bool
    {
        $value = strtolower(trim($raw, " \n\r\t\v\0"));

        if (preg_match('/^[0-9a-f]{16}$/', $value) !== 1) {
            return false;
        }

        return $value !== str_repeat('0', 16);
    }
}
