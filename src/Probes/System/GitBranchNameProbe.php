<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Git branch names.
 */
class GitBranchNameProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Za-z0-9._\/-]+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GIT_BRANCH_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GIT_BRANCH_NAME;
    }
}
