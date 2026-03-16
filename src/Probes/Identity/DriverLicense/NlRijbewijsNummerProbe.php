<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Dutch driver licence numbers.
 */
class NlRijbewijsNummerProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NL_RIJBEWIJS_NUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NL_RIJBEWIJS_NUMMER;
    }
}
