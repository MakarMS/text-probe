<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\CompanyRegistration\EsCifControlValidator;
use Override;

/**
 * Probe that extracts Spanish CIF numbers.
 */
class EsCifProbe extends Probe implements IProbe
{
    public function __construct(?EsCifControlValidator $validator = null)
    {
        parent::__construct($validator ?? new EsCifControlValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]\d{7}[A-Z0-9]$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ES_CIF
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ES_CIF;
    }
}
