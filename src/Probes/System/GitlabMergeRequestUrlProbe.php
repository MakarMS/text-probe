<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Gitlab Merge Request Url values from text.
 *
 * Examples:
 * - valid: `https://gitlab.com/acme/app/-/merge_requests/12`
 * - invalid: `https://gitlab.com/acme/app`
 *
 * Constraints:
 * - Uses regex pattern `~https?://gitlab\.com/[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+/-/merge_requests/\d+\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class GitlabMergeRequestUrlProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://gitlab\.com/[A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+/-/merge_requests/\d+\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITLAB_MERGE_REQUEST_URL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITLAB_MERGE_REQUEST_URL;
    }
}
