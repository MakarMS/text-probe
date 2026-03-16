<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\PlNipChecksumValidator;

/**
 * Probe that extracts Polish NIP numbers.
 */
class PlNipProbe extends Probe implements IProbe
{
    public function __construct(?PlNipChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new PlNipChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PL_NIP
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PL_NIP;
    }
}
