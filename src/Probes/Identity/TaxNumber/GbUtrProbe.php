<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts UK Unique Taxpayer Reference (UTR) numbers.
 */
class GbUtrProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{10}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GB_UTR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GB_UTR;
    }
}
