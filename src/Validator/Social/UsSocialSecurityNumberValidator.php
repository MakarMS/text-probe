<?php

namespace TextProbe\Validator\Social;

use TextProbe\Validator\Contracts\IValidator;
use Override;

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
    #[Override]
    public function validate(string $raw): bool
    {
        if (preg_match('/^(\d{3})-(\d{2})-(\d{4})$/', $raw, $matches) !== 1) {
            return false;
        }

        [, $area, $group, $serial] = $matches;

        if ((int) $area === 0 || (int) $area === 666 || (int) $area >= 900) {
            return false;
        }

        if ((int) $group === 0) {
            return false;
        }

        return (int) $serial !== 0;
    }
}
