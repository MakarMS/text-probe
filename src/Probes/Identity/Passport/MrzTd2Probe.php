<?php

namespace TextProbe\Probes\Identity\Passport;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts MRZ TD2 blocks.
 */
class MrzTd2Probe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?<l1>[A-Z0-9<]{36})\r?\n(?<l2>[A-Z0-9<]{36})$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MRZ_TD2
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MRZ_TD2;
    }
}
