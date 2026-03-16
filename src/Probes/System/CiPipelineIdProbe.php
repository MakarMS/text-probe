<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts CI pipeline IDs.
 */
class CiPipelineIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CI_PIPELINE_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CI_PIPELINE_ID;
    }
}
