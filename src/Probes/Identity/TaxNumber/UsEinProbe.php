<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts US EIN numbers.
 */
class UsEinProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{2}-\d{7}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::US_EIN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::US_EIN;
    }
}
