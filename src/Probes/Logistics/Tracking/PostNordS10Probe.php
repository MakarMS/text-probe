<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * Probe that extracts PostNord  S10 tracking numbers.
 */
class PostNordS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}(?:SE|NO|DK|FI)$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::POST_NORD_S10
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::POST_NORD_S10;
    }
}
