<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts AWS IAM role ARNs.
 *
 * Examples:
 * - valid: `arn:aws:iam::123456789012:role/Admin`
 * - valid: `arn:aws-us-gov:iam::123456789012:role/service-role/LambdaRole`
 *
 * Constraints:
 * - Matches IAM role ARNs with 12-digit accounts and role paths/names using common IAM characters. It does not call AWS IAM, verify trust policies, or support non-role IAM resources.
 * - Uses regex pattern `/\barn:aws[a-z-]*:iam::\d{12}:role\/[A-Za-z0-9+=,.@_\/-]+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsIamRoleArnProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\barn:aws[a-z-]*:iam::\\d{12}:role\\/[A-Za-z0-9+=,.@_\\/-]+\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_IAM_ROLE_ARN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_IAM_ROLE_ARN;
    }
}
