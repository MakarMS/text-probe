<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\PlPeselChecksumValidator;

/**
 * Probe that extracts Polish PESEL numbers.
 */
class PlPeselProbe extends Probe implements IProbe
{
    public function __construct(?PlPeselChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new PlPeselChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{11}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PL_PESEL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PL_PESEL;
    }
}
