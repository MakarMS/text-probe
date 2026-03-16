<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Swiss UIDI numbers.
 */
class ChUidiProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^CHE-\d{3}\.\d{3}\.\d{3}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CH_UIDI
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CH_UIDI;
    }
}
