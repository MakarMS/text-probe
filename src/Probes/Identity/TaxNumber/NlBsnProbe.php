<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\NlBsn11ProefValidator;
use Override;

/**
 * Probe that extracts Dutch BSN numbers.
 */
class NlBsnProbe extends Probe implements IProbe
{
    public function __construct(?NlBsn11ProefValidator $validator = null)
    {
        parent::__construct($validator ?? new NlBsn11ProefValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NL_BSN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NL_BSN;
    }
}
