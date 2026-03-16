<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\NoFoedselsnummerChecksumValidator;
use Override;

/**
 * Probe that extracts Norwegian fødselsnummer identifiers.
 */
class NoFoedselsnummerProbe extends Probe implements IProbe
{
    public function __construct(?NoFoedselsnummerChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new NoFoedselsnummerChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{11}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NO_FOEDSELSNUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NO_FOEDSELSNUMMER;
    }
}
