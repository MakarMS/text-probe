<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Polish driver licence numbers.
 */
class PlNumerPrawaJazdyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{5}\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PL_NUMER_PRAWA_JAZDY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PL_NUMER_PRAWA_JAZDY;
    }
}
