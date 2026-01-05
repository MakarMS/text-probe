<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\MedicalPolicy\FrNirMod97Validator;

/**
 * Probe that extracts French NIR numbers.
 */
class FrNirProbe extends Probe implements IProbe
{
    public function __construct(?FrNirMod97Validator $validator = null)
    {
        parent::__construct($validator ?? new FrNirMod97Validator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{13}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FR_NIR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FR_NIR;
    }
}
