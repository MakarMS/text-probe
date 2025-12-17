<?php

namespace TextProbe\Validator\Web;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator that ensures matched cookie fragments look like real cookie
 * assignments rather than cookie attributes or malformed pairs.
 */
class CookieValidator implements IValidator
{
    /** @var array<string> */
    private array $forbiddenNames = [
        'path',
        'expires',
        'max-age',
        'domain',
        'samesite',
        'secure',
        'httponly',
        'priority',
        'version',
        'comment',
    ];

    public function validate(string $raw): bool
    {
        if (preg_match(
            "/^(?:Set-Cookie:\\s*|Cookie:\\s*)?(?<name>[!#$%&'*+.^_`|~0-9A-Za-z-]{1,128})\\s*=\\s*(?<value>\\\"[^\\\"]*\\\"|[!#$%&'*+.^_`|~0-9A-Za-z-]{1,2048})/i",
            trim($raw),
            $matches,
        ) !== 1) {
            return false;
        }

        $name = strtolower($matches['name']);

        if (in_array($name, $this->forbiddenNames, true)) {
            return false;
        }

        $value = trim($matches['value'], ' "');

        return $value !== '';
    }
}
