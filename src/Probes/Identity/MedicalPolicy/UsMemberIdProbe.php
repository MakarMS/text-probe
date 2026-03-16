<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts US member identifiers.
 */
class UsMemberIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z0-9]{8,16}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::US_MEMBER_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::US_MEMBER_ID;
    }
}
