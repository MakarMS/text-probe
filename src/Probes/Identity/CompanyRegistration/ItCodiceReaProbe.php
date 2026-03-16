<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Italian codice REA numbers.
 */
class ItCodiceReaProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}-\d{1,8}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IT_CODICE_REA
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IT_CODICE_REA;
    }
}
