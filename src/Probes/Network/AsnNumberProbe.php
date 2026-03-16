<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Asn Number values from text.
 *
 * Examples:
 * - valid: `AS13335`
 * - invalid: `AS0`
 *
 * Constraints:
 * - Uses regex pattern `/\bAS(?:[1-9]\d{0,9})\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AsnNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bAS(?:[1-9]\d{0,9})\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ASN_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ASN_NUMBER;
    }
}
