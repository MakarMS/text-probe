<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;

/**
 * Probe that extracts Poste Italiane  S10 tracking numbers.
 */
class PosteItalianeS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}IT$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::POSTE_ITALIANE_S10
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::POSTE_ITALIANE_S10;
    }
}
