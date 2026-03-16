<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\EsNifControlValidator;
use Override;

/**
 * Probe that extracts Spanish NIF identifiers.
 */
class EsNifProbe extends Probe implements IProbe
{
    public function __construct(?EsNifControlValidator $validator = null)
    {
        parent::__construct($validator ?? new EsNifControlValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z0-9]\d{7}[A-Z0-9]$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ES_NIF
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ES_NIF;
    }
}
