<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Imsi values from text.
 *
 * Examples:
 * - valid: `310150123456789`
 * - invalid: `31015012345678`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{15}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class ImsiProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{15}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IMSI
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IMSI;
    }
}
