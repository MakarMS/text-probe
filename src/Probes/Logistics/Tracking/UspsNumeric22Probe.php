<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USPS Numeric22 tracking numbers.
 */
class UspsNumeric22Probe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{22}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::USPS_NUMERIC_22
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::USPS_NUMERIC_22;
    }
}
