<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\CompanyRegistration\FrSiretLuhnValidator;

/**
 * Probe that extracts French SIRET numbers.
 */
class FrSiretProbe extends Probe implements IProbe
{
    public function __construct(?FrSiretLuhnValidator $validator = null)
    {
        parent::__construct($validator ?? new FrSiretLuhnValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{14}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FR_SIRET
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FR_SIRET;
    }
}
