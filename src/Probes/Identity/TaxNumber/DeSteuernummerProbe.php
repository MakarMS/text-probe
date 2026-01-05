<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts German Steuernummer identifiers.
 */
class DeSteuernummerProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{2}\/\d{3}\/\d{5}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DE_STEUERNUMMER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DE_STEUERNUMMER;
    }
}
