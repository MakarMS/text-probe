<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts PostNL Tracking tracking numbers.
 */
class PostnlTrackingProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^3S\d{13}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::POSTNL_TRACKING
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::POSTNL_TRACKING;
    }
}
