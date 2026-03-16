<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts FedEx 20 tracking numbers.
 */
class Fedex20Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{20}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FEDEX_20
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FEDEX_20;
    }
}
