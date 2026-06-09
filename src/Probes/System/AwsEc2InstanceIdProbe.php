<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts AWS EC2 instance IDs.
 *
 * Examples:
 * - valid: `i-1234567890abcdef0`
 * - valid: `i-abcdef12`
 *
 * Constraints:
 * - Matches `i-` followed by 8-17 lowercase hexadecimal characters. It does not distinguish old and new EC2 ID allocation modes, call AWS, or verify region/account ownership.
 * - Uses regex pattern `/\bi-[0-9a-f]{8,17}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsEc2InstanceIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\bi-[0-9a-f]{8,17}\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_EC2_INSTANCE_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_EC2_INSTANCE_ID;
    }
}
