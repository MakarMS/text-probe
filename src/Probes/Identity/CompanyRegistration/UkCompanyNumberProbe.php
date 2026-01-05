<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts UK company registration numbers.
 */
class UkCompanyNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?:\d{8}|[A-Z]{2}\d{6})$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GB_COMPANY_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GB_COMPANY_NUMBER;
    }
}
