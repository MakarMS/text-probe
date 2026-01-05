<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\CompanyRegistration\RuOgrnChecksumValidator;

/**
 * Probe that extracts Russian OGRN numbers.
 */
class RuOgrnProbe extends Probe implements IProbe
{
    public function __construct(?RuOgrnChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new RuOgrnChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{13}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RU_OGRN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RU_OGRN;
    }
}
