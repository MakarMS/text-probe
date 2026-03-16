<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts US company registration numbers.
 */
class UsCompanyRegistrationNumberProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z0-9]{6,12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::US_COMPANY_REGISTRATION_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::US_COMPANY_REGISTRATION_NUMBER;
    }
}
