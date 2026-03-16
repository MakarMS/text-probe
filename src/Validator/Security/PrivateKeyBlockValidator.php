<?php

namespace TextProbe\Validator\Security;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for PEM/OpenSSH private key blocks.
 *
 * Ensures the matched block contains at least one base64-looking line.
 */
class PrivateKeyBlockValidator implements IValidator
{
    #[\Override]
    public function validate(string $raw): bool
    {
        return (bool) preg_match('~^[A-Za-z0-9+/=]+$~m', $raw);
    }
}
