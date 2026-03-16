<?php

namespace TextProbe\Probes\Logistics;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Eu Eori Number values from text.
 *
 * Examples:
 * - valid: `DE123456789012`
 * - invalid: `D1234`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Z]{2}[A-Z0-9]{8,15}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class EuEoriNumberProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{2}[A-Z0-9]{8,15}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::EU_EORI_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EU_EORI_NUMBER;
    }
}
