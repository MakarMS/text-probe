<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\CompanyRegistration\FrSirenLuhnValidator;

/**
 * Probe that extracts French SIREN numbers.
 */
class FrSirenProbe extends Probe implements IProbe
{
    public function __construct(?FrSirenLuhnValidator $validator = null)
    {
        parent::__construct($validator ?? new FrSirenLuhnValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FR_SIREN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FR_SIREN;
    }
}
