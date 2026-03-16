<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Norwegian driver licence numbers.
 */
class NoFoererkortnummerProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{11}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NO_FOERERKORTNUMMER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NO_FOERERKORTNUMMER;
    }
}
