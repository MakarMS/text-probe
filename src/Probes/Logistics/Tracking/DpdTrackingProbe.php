<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts DPD Tracking tracking numbers.
 */
class DpdTrackingProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{14}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DPD_TRACKING
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DPD_TRACKING;
    }
}
