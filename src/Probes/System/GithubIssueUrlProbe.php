<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Github Issue Url values from text.
 *
 * Examples:
 * - valid: `https://github.com/acme/app/issues/12`
 * - invalid: `https://github.com/acme/app`
 *
 * Constraints:
 * - Uses regex pattern `~https?://github\.com/[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+/issues/\d+\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class GithubIssueUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://github\.com/[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+/issues/\d+\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_ISSUE_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_ISSUE_URL;
    }
}
