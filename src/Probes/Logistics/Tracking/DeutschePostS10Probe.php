<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * Probe that extracts Deutsche Post  S10 tracking numbers.
 */
class DeutschePostS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}DE$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DEUTSCHE_POST_S10
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DEUTSCHE_POST_S10;
    }
}
