<?php

namespace TextProbe\Probes\Identity\Passport;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts MRZ TD3 blocks.
 */
class MrzTd3Probe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?<l1>[A-Z0-9<]{44})\r?\n(?<l2>[A-Z0-9<]{44})$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MRZ_TD3
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MRZ_TD3;
    }
}
