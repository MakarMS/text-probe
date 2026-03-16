<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts UK driving licence numbers.
 */
class UkDrivingLicenceNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z9]{5}\d{6}[A-Z9]{2}\d[A-Z]{2}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UK_DRIVING_LICENCE_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UK_DRIVING_LICENCE_NUMBER;
    }
}
