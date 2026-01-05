<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USPS Numeric20 tracking numbers.
 */
class UspsNumeric20Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{20}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::USPS_NUMERIC_20
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::USPS_NUMERIC_20;
    }
}
