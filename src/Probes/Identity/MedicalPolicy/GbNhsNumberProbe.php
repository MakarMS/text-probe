<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\MedicalPolicy\GbNhsChecksumValidator;

/**
 * Probe that extracts UK NHS numbers.
 */
class GbNhsNumberProbe extends Probe implements IProbe
{
    public function __construct(?GbNhsChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new GbNhsChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?:\d{10}|\d{3}\s?\d{3}\s?\d{4})$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GB_NHS_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GB_NHS_NUMBER;
    }
}
