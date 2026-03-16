<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * Probe that extracts Poczta Polska  S10 tracking numbers.
 */
class PocztaPolskaS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}PL$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::POCZTA_POLSKA_S10
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::POCZTA_POLSKA_S10;
    }
}
