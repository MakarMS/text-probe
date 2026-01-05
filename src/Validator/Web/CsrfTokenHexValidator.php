<?php

namespace TextProbe\Validator\Web;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for hexadecimal CSRF tokens.
 *
 * Ensures the token length is within 32-128 characters and is even.
 */
class CsrfTokenHexValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $length = strlen($raw);

        if ($length < 32 || $length > 128) {
            return false;
        }

        if ($length % 2 !== 0) {
            return false;
        }

        return (bool) preg_match('/^[a-fA-F0-9]+$/', $raw);
    }
}
