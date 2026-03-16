<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\NlBsn11ProefValidator;

/**
 * Probe that extracts Dutch BSN medical identifiers.
 */
class NlBsnMedicalProbe extends Probe implements IProbe
{
    public function __construct(?NlBsn11ProefValidator $validator = null)
    {
        parent::__construct($validator ?? new NlBsn11ProefValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NL_BSN_MEDICAL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NL_BSN_MEDICAL;
    }
}
