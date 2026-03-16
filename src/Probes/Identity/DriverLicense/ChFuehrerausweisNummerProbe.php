<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Swiss driver licence numbers.
 */
class ChFuehrerausweisNummerProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CH_FUEHRERAUSWEIS_NUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CH_FUEHRERAUSWEIS_NUMMER;
    }
}
