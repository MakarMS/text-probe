<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts German driver licence numbers.
 */
class DeFuehrerscheinnummerProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z0-9]{11,13}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DE_FUEHRERSCHEINNUMMER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DE_FUEHRERSCHEINNUMMER;
    }
}
