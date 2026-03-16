<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts GLS Tracking tracking numbers.
 */
class GlsTrackingProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{11,14}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GLS_TRACKING
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GLS_TRACKING;
    }
}
