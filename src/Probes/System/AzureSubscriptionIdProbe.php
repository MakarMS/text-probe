<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Azure subscription UUIDs.
 *
 * Examples:
 * - valid: `12345678-1234-1234-1234-123456789abc`
 * - valid: `abcdefab-cdef-abcd-efab-cdefabcdefab`
 *
 * Constraints:
 * - Matches UUID-shaped identifiers. It does not distinguish subscription IDs from tenant IDs, KMS keys, or arbitrary UUIDs, and it does not query Azure.
 * - Uses regex pattern `/\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AzureSubscriptionIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AZURE_SUBSCRIPTION_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AZURE_SUBSCRIPTION_ID;
    }
}
