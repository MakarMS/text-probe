<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Polish KRS numbers.
 */
class PlKrsProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PL_KRS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PL_KRS;
    }
}
