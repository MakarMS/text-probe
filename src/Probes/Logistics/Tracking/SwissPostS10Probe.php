<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * Probe that extracts Swiss Post  S10 tracking numbers.
 */
class SwissPostS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}CH$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SWISS_POST_S10
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SWISS_POST_S10;
    }
}
