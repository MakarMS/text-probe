<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Dutch driver licence numbers.
 */
class NlRijbewijsNummerProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NL_RIJBEWIJS_NUMMER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NL_RIJBEWIJS_NUMMER;
    }
}
