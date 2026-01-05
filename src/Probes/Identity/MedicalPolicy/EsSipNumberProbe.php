<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Spanish SIP numbers.
 */
class EsSipNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ES_SIP_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ES_SIP_NUMBER;
    }
}
