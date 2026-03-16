<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts short Git commit SHAs.
 */
class GitShortShaProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[0-9a-f]{7,12}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GIT_SHORT_SHA
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GIT_SHORT_SHA;
    }
}
