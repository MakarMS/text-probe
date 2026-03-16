<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Aws Arn values from text.
 *
 * Examples:
 * - valid: `arn:aws:iam::123456789012:role/S3Access`
 * - invalid: `arn:aws:iam::role/S3Access`
 *
 * Constraints:
 * - Uses regex pattern `/\barn:aws[a-z-]*:[a-z0-9-]*:[a-z0-9-]*:\d{12}:[^\s]+\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsArnProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\barn:aws[a-z-]*:[a-z0-9-]*:[a-z0-9-]*:\d{12}:[^\s]+\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_ARN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_ARN;
    }
}
