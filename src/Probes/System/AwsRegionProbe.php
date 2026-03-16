<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Aws Region values from text.
 *
 * Examples:
 * - valid: `eu-central-1`
 * - invalid: `europe-central-1`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:us|eu|ap|sa|ca|me|af)-[a-z]+-\d\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsRegionProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:us|eu|ap|sa|ca|me|af)-[a-z]+-\d\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_REGION
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_REGION;
    }
}
