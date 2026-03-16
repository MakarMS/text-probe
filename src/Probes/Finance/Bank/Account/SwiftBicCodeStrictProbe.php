<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Swift Bic Code Strict values from text.
 *
 * Examples:
 * - valid: `DEUTDEFF500`
 * - invalid: `DEUTD`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Z]{6}[A-Z0-9]{2}(?:[A-Z0-9]{3})?\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class SwiftBicCodeStrictProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{6}[A-Z0-9]{2}(?:[A-Z0-9]{3})?\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SWIFT_BIC_CODE_STRICT
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SWIFT_BIC_CODE_STRICT;
    }
}
