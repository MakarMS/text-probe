<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\RuInnChecksumValidator;

/**
 * Probe that extracts Russian tax identification numbers (INN).
 */
class RuInnProbe extends Probe implements IProbe
{
    public function __construct(?RuInnChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new RuInnChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?:\d{10}|\d{12})$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RU_INN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RU_INN;
    }
}
