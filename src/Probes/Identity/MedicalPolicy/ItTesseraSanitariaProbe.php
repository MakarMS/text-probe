<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\ItCodiceFiscaleControlCharValidator;

/**
 * Probe that extracts Italian tessera sanitaria identifiers.
 */
class ItTesseraSanitariaProbe extends Probe implements IProbe
{
    public function __construct(?ItCodiceFiscaleControlCharValidator $validator = null)
    {
        parent::__construct($validator ?? new ItCodiceFiscaleControlCharValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IT_TESSERA_SANITARIA
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IT_TESSERA_SANITARIA;
    }
}
