<?php

namespace TextProbe\Validator\Identity\MedicalPolicy;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for French NIR numbers without key digits.
 *
 * 13-digit NIR values do not include the 2-digit key required for Mod-97,
 * so this validator only enforces format/length and does not compute Mod-97.
 */
class FrNirMod97Validator implements IValidator
{
    public function validate(string $raw): bool
    {
        return preg_match('/^\d{13}$/', $raw) === 1;
    }
}
