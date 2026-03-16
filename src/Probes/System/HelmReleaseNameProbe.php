<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Helm Release Name values from text.
 *
 * Examples:
 * - valid: `my-release-1`
 * - invalid: `MY_RELEASE`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z0-9](?:-?[a-z0-9]){2,52}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class HelmReleaseNameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z0-9](?:-?[a-z0-9]){2,52}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HELM_RELEASE_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HELM_RELEASE_NAME;
    }
}
