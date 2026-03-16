<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Github Pull Request Url values from text.
 *
 * Examples:
 * - valid: `https://github.com/acme/app/pulls`
 * - invalid: `https://github.com/acme/app/pull`
 *
 * Constraints:
 * - Uses regex pattern `~https?://github\.com/[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+/pull/\d+\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class GithubPullRequestUrlProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://github\.com/[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+/pull/\d+\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_PULL_REQUEST_URL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_PULL_REQUEST_URL;
    }
}
