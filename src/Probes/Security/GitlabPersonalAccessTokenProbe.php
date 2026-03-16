<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Gitlab Personal Access Token values from text.
 *
 * Examples:
 * - valid: `glpat-abcdefghijklmnopqrst`
 * - invalid: `glpat-short`
 *
 * Constraints:
 * - Uses regex pattern `/\bglpat-[A-Za-z0-9\-_]{20}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class GitlabPersonalAccessTokenProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bglpat-[A-Za-z0-9\-_]{20}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITLAB_PERSONAL_ACCESS_TOKEN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITLAB_PERSONAL_ACCESS_TOKEN;
    }
}
