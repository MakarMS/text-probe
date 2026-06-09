<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Google Cloud project IDs.
 *
 * Examples:
 * - valid: `my-project-123`
 * - valid: `prod123456`
 *
 * Constraints:
 * - Matches lowercase project IDs 6-30 characters long, starting with a letter and ending with a letter or digit. It does not call Google Cloud, verify uniqueness/existence, and can match ordinary lowercase tokens that satisfy the same shape.
 * - Uses regex pattern `/\b[a-z][a-z0-9-]{4,28}[a-z0-9]\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class GcpProjectIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[a-z][a-z0-9-]{4,28}[a-z0-9]\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GCP_PROJECT_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GCP_PROJECT_ID;
    }
}
