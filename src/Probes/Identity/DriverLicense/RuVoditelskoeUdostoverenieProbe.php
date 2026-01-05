<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Russian driver licence numbers.
 */
class RuVoditelskoeUdostoverenieProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{2}\s?\d{2}\s?\d{6}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RU_VODITELSKOE_UDOSTOVERENIE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RU_VODITELSKOE_UDOSTOVERENIE;
    }
}
