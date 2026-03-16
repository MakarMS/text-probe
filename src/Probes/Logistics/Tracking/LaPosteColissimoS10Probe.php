<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Logistics\Tracking\UpuS10CheckDigitValidator;
use Override;

/**
 * Probe that extracts La Poste Colissimo  S10 tracking numbers.
 */
class LaPosteColissimoS10Probe extends Probe implements IProbe
{
    public function __construct(?UpuS10CheckDigitValidator $validator = null)
    {
        parent::__construct($validator ?? new UpuS10CheckDigitValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{9}FR$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LA_POSTE_COLISSIMO_S10
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LA_POSTE_COLISSIMO_S10;
    }
}
