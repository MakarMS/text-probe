<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts environment variable assignments.
 */
class EnvAssignmentProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Za-z_][A-Za-z0-9_]*=.*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ENV_ASSIGNMENT
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ENV_ASSIGNMENT;
    }
}
