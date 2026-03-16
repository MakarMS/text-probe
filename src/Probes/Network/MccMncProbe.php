<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Mcc Mnc values from text.
 *
 * Examples:
 * - valid: `310-260`
 * - invalid: `31-260`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{3}-\d{2,3}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class MccMncProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{3}-\d{2,3}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MCC_MNC
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MCC_MNC;
    }
}
