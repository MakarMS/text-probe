<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Git tag names.
 */
class GitTagProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^v?[0-9A-Za-z][0-9A-Za-z._-]*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GIT_TAG
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GIT_TAG;
    }
}
