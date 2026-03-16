<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\SePersonnummerLuhnValidator;
use Override;

/**
 * Probe that extracts Swedish personnummer identifiers.
 */
class SePersonnummerProbe extends Probe implements IProbe
{
    public function __construct(?SePersonnummerLuhnValidator $validator = null)
    {
        parent::__construct($validator ?? new SePersonnummerLuhnValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?:\d{8}|\d{6})[-+]?\d{4}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SE_PERSONNUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SE_PERSONNUMMER;
    }
}
