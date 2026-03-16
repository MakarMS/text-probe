<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts FedEx 12 tracking numbers.
 */
class Fedex12Probe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FEDEX_12
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FEDEX_12;
    }
}
