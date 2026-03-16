<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Commit Conventional Type values from text.
 *
 * Examples:
 * - valid: `feat(api): add endpoint`
 * - invalid: `feature: add endpoint`
 *
 * Constraints:
 * - Uses regex pattern `/(?:feat|fix|docs|style|refactor|perf|test|build|ci|chore)(?:\([\w.-]+\))?:\s[^\n]+/m`.
 * - Relies on regex filtering only (no additional validator).
 */
class CommitConventionalTypeProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?:feat|fix|docs|style|refactor|perf|test|build|ci|chore)(?:\([\w.-]+\))?:\s[^\n]+/m', $text);
    }

    /**
     * @return ProbeType returns ProbeType::COMMIT_CONVENTIONAL_TYPE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::COMMIT_CONVENTIONAL_TYPE;
    }
}
