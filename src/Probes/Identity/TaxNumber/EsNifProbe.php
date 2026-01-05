<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\EsNifControlValidator;

/**
 * Probe that extracts Spanish NIF identifiers.
 */
class EsNifProbe extends Probe implements IProbe
{
    public function __construct(?EsNifControlValidator $validator = null)
    {
        parent::__construct($validator ?? new EsNifControlValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z0-9]\d{7}[A-Z0-9]$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ES_NIF
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ES_NIF;
    }
}
