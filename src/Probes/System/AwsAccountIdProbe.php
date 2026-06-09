<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts AWS account IDs.
 *
 * Examples:
 * - valid: `123456789012`
 * - valid: `210987654321`
 *
 * Constraints:
 * - Matches exactly 12 digits bounded by non-digits. It does not verify AWS account existence, partition, ownership, or whether the number appears in an ARN or another unrelated numeric identifier.
 * - Uses regex pattern `/(?<!\d)\d{12}(?!\d)/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsAccountIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\\d)\\d{12}(?!\\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_ACCOUNT_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_ACCOUNT_ID;
    }
}
