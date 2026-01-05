<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Git commit hashes.
 */
class GitCommitHashProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[0-9a-f]{7,40}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GIT_COMMIT_HASH
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GIT_COMMIT_HASH;
    }
}
