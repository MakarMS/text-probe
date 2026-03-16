<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\DeSteuerIdChecksumValidator;

/**
 * Probe that extracts German Steuer-ID numbers.
 */
class DeSteuerIdProbe extends Probe implements IProbe
{
    public function __construct(?DeSteuerIdChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new DeSteuerIdChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{11}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DE_STEUER_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DE_STEUER_ID;
    }
}
