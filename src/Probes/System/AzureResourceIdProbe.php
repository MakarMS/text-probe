<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Azure resource IDs.
 *
 * Examples:
 * - valid: `/subscriptions/12345678-1234-1234-1234-123456789abc/resourceGroups/rg-prod/providers/Microsoft.Storage/storageAccounts/appstore`
 * - valid: `/subscriptions/abcdefab-cdef-abcd-efab-cdefabcdefab/resourceGroups/rg/providers/Microsoft.Web/sites/app`
 *
 * Constraints:
 * - Matches subscription, resource group, provider namespace, and trailing resource path text. It does not call Azure Resource Manager, validate provider/type combinations, enforce resource-group naming rules fully, or verify that the resource exists.
 * - Uses regex pattern `~/subscriptions/[0-9a-f-]{36}/resourceGroups/[A-Za-z0-9_.()\-]+/providers/[A-Za-z.]+/[A-Za-z0-9_.\-/]+\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AzureResourceIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~/subscriptions/[0-9a-f-]{36}/resourceGroups/[A-Za-z0-9_.()\\-]+/providers/[A-Za-z.]+/[A-Za-z0-9_.\\-/]+\\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AZURE_RESOURCE_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AZURE_RESOURCE_ID;
    }
}
