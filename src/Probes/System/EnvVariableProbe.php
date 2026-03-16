<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts environment variable names.
 */
class EnvVariableProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Za-z_][A-Za-z0-9_]*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ENV_VARIABLE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ENV_VARIABLE;
    }
}
