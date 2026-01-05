<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts DHL Express10 tracking numbers.
 */
class DhlExpress10Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DHL_EXPRESS_10
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DHL_EXPRESS_10;
    }
}
