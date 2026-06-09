<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts AWS S3 bucket names.
 *
 * Examples:
 * - valid: `my-app-bucket`
 * - valid: `logs.example.bucket`
 *
 * Constraints:
 * - Matches 3-63 lowercase letters, digits, dots, and hyphens, excludes IPv4-looking values, and requires alphanumeric start/end characters. It does not enforce every S3 naming edge case such as adjacent dots or dash-dot combinations, and ordinary lowercase words can match if they fit the bucket-name shape.
 * - Uses regex pattern `/\b(?!\d+\.\d+\.\d+\.\d+\b)[a-z0-9][a-z0-9.-]{1,61}[a-z0-9]\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsS3BucketNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?!\\d+\\.\\d+\\.\\d+\\.\\d+\\b)[a-z0-9][a-z0-9.-]{1,61}[a-z0-9]\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_S3_BUCKET_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_S3_BUCKET_NAME;
    }
}
