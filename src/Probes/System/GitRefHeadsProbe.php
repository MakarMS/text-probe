<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Git refs/heads references.
 */
class GitRefHeadsProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^refs\/heads\/[A-Za-z0-9._\/-]+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GIT_REF_HEADS
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GIT_REF_HEADS;
    }
}
