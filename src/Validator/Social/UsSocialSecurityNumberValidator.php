<?php

namespace TextProbe\Validator\Social;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for U.S. Social Security Numbers (SSN) in the `XXX-XX-XXXX` format.
 *
 * The validation rules are based on SSA guidelines and aim to reduce false
 * positives by rejecting:
 * - area numbers of `000`, `666`, or any value from `900` to `999`,
 * - group numbers of `00`,
 * - serial numbers of `0000`.
 */
class UsSocialSecurityNumberValidator implements IValidator
{
    /**
     * Validates a Social Security Number candidate.
     *
     * The method checks for the exact `NNN-NN-NNNN` structure and then enforces
     * the SSA-issued constraints on area, group, and serial parts to eliminate
     * structurally invalid numbers.
     */
    public function validate(string $raw): bool
    {
        if (preg_match('/^(\d{3})-(\d{2})-(\d{4})$/', $raw, $matches) !== 1) {
            return false;
        }

        [, $area, $group, $serial] = $matches;

        if ($area === '000' || $area === '666' || (int) $area >= 900) {
            return false;
        }

        if ($group === '00') {
            return false;
        }

        return !($serial === '0000');
    }
}
