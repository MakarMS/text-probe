<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\ChAhvChecksumValidator;

/**
 * Probe that extracts Swiss AHV medical identifiers.
 */
class ChAhvMedicalProbe extends Probe implements IProbe
{
    public function __construct(?ChAhvChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new ChAhvChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^756\.\d{4}\.\d{4}\.\d{2}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CH_AHV_MEDICAL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CH_AHV_MEDICAL;
    }
}
