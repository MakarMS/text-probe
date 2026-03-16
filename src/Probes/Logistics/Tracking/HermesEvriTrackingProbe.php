<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Hermes/Evri Tracking tracking numbers.
 */
class HermesEvriTrackingProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^H\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HERMES_EVRI_TRACKING
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HERMES_EVRI_TRACKING;
    }
}
