<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts French driver licence numbers.
 */
class FrNumeroPermisDeConduireProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FR_NUMERO_PERMIS_DE_CONDUIRE;
    }
}
