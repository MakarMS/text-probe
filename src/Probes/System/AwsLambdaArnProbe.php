<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts AWS Lambda function ARNs.
 *
 * Examples:
 * - valid: `arn:aws:lambda:us-east-1:123456789012:function:processor`
 * - valid: `arn:aws-us-gov:lambda:us-gov-west-1:123456789012:function:processor:prod`
 *
 * Constraints:
 * - Supports AWS partitions like `aws` and `aws-us-gov`, one region segment, 12-digit account IDs, function names, and optional qualifiers. It does not validate region availability, function existence, aliases, versions, or permissions.
 * - Uses regex pattern `/\barn:aws[a-z-]*:lambda:[a-z0-9-]+:\d{12}:function:[A-Za-z0-9-_]+(?::[A-Za-z0-9-_]+)?\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsLambdaArnProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\barn:aws[a-z-]*:lambda:[a-z0-9-]+:\\d{12}:function:[A-Za-z0-9-_]+(?::[A-Za-z0-9-_]+)?\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_LAMBDA_ARN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_LAMBDA_ARN;
    }
}
