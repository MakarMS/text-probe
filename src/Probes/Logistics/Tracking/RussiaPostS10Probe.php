<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * Probe that extracts Russia Post  S10 tracking numbers.
 */
class RussiaPostS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}RU$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RUSSIA_POST_S10
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RUSSIA_POST_S10;
    }
}
