<?php

namespace TextProbe\Validator;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator that unconditionally accepts all values.
 *
 * This is the default validator used when no explicit validator is provided.
 * It performs no checks and always returns true from {@see validate()}.
 */
class NoopValidator implements IValidator
{
    /**
     * Always returns true, effectively disabling validation.
     *
     * @param string $raw raw value to "validate"
     *
     * @return bool always true
     */
    public function validate(string $raw): bool
    {
        return true;
    }
}
