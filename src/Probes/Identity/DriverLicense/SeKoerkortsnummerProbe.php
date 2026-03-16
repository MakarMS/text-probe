<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Swedish driver licence numbers.
 */
class SeKoerkortsnummerProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SE_KOERKORTSNUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SE_KOERKORTSNUMMER;
    }
}
