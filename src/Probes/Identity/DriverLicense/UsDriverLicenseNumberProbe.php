<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts US driver licence numbers.
 */
class UsDriverLicenseNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z0-9]{7,14}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::US_DRIVER_LICENSE_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::US_DRIVER_LICENSE_NUMBER;
    }
}
