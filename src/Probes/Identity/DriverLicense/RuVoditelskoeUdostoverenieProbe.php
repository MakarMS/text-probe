<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Russian driver licence numbers.
 */
class RuVoditelskoeUdostoverenieProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{2}\s?\d{2}\s?\d{6}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RU_VODITELSKOE_UDOSTOVERENIE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RU_VODITELSKOE_UDOSTOVERENIE;
    }
}
