<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Azure tenant UUIDs.
 *
 * Examples:
 * - valid: `87654321-4321-4321-4321-cba987654321`
 * - valid: `abcdefab-cdef-abcd-efab-cdefabcdefab`
 *
 * Constraints:
 * - Matches UUID-shaped identifiers. It does not distinguish tenant IDs from subscription IDs or unrelated UUIDs, and it does not verify Azure Entra tenant existence.
 * - Uses regex pattern `/\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AzureTenantIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AZURE_TENANT_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AZURE_TENANT_ID;
    }
}
