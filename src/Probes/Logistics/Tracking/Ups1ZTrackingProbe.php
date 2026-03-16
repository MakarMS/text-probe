<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\Ups1ZCheckDigitValidator;

/**
 * Probe that extracts UPS 1Z tracking numbers.
 */
class Ups1ZTrackingProbe extends Probe implements IProbe
{
    public function __construct(?Ups1ZCheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new Ups1ZCheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^1Z[0-9A-Z]{16}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UPS_1Z_TRACKING
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UPS_1Z_TRACKING;
    }
}
