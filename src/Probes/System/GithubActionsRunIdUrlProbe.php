<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts GitHub Actions run URLs.
 */
class GithubActionsRunIdUrlProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^https:\/\/github\.com\/[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+\/actions\/runs\/\d+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_ACTIONS_RUN_ID_URL
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_ACTIONS_RUN_ID_URL;
    }
}
