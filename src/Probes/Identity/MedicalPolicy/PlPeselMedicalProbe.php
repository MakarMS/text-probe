<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\PlPeselChecksumValidator;

/**
 * Probe that extracts Polish PESEL medical identifiers.
 */
class PlPeselMedicalProbe extends Probe implements IProbe
{
    public function __construct(?PlPeselChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new PlPeselChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{11}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PL_PESEL_MEDICAL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PL_PESEL_MEDICAL;
    }
}
