<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts AWS KMS key UUIDs.
 *
 * Examples:
 * - valid: `12345678-1234-1234-1234-123456789abc`
 * - valid: `abcdefab-cdef-abcd-efab-cdefabcdefab`
 *
 * Constraints:
 * - Matches UUID-shaped key IDs only. It does not require a `key/` prefix, verify that the UUID is an AWS KMS key, check aliases, or query key state.
 * - Uses regex pattern `/\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsKmsKeyIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_KMS_KEY_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_KMS_KEY_ID;
    }
}
