<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Russian OMS ENP16 numbers.
 */
class RuOmsEnp16Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{16}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RU_OMS_ENP16
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RU_OMS_ENP16;
    }
}
