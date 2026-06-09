<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Docker Hub personal access tokens (`dckr_pat_...`).
 *
 * Examples:
 * - valid: `dckr_pat_abcdefghijklmnopqrstuvwxyz_123456`
 * - valid: `dckr_pat_ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456`
 *
 * Constraints:
 * - Requires the `dckr_pat_` prefix and at least 20 token characters. It does not contact Docker Hub, verify user ownership, or inspect repository permissions.
 * - Uses regex pattern `~\bdckr_pat_[A-Za-z0-9_-]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class DockerHubTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bdckr_pat_[A-Za-z0-9_-]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_HUB_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_HUB_TOKEN;
    }
}
