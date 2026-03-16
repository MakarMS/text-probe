<?php

namespace TextProbe\Probes\Identity\Passport;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts MRZ TD1 blocks.
 */
class MrzTd1Probe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?<l1>[A-Z0-9<]{30})\r?\n(?<l2>[A-Z0-9<]{30})\r?\n(?<l3>[A-Z0-9<]{30})$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MRZ_TD1
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MRZ_TD1;
    }
}
