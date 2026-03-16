<?php

namespace TextProbe\Probes\Identity\Passport;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Us Passport Number values from text.
 *
 * Examples:
 * - valid: `123456789`
 * - invalid: `12345678`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{9}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class UsPassportNumberProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{9}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::US_PASSPORT_NUMBER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::US_PASSPORT_NUMBER;
    }
}
