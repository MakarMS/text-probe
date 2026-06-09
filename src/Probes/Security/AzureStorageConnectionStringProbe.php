<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Azure Storage connection strings.
 *
 * Examples:
 * - valid: `DefaultEndpointsProtocol=https;AccountName=accountname;AccountKey=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234567890+/==`
 * - valid: `DefaultEndpointsProtocol=http;AccountName=acct123;AccountKey=abcdefghijklmnopqrstuvwxyz1234567890+/=;EndpointSuffix=core.windows.net`
 *
 * Constraints:
 * - Requires `DefaultEndpointsProtocol`, `AccountName`, and `AccountKey` fields in that order, with optional `EndpointSuffix`. It does not base64-decode the account key, contact Azure, or support every possible connection-string key such as SAS-only forms.
 * - Uses regex pattern `~\bDefaultEndpointsProtocol=https?;AccountName=[a-z0-9]{3,24};AccountKey=[A-Za-z0-9+/=]{20,}(?:;EndpointSuffix=[A-Za-z0-9.-]+)?(?=$|[\s,.;)])~`.
 * - Relies on regex filtering only (no additional validator).
 */
class AzureStorageConnectionStringProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bDefaultEndpointsProtocol=https?;AccountName=[a-z0-9]{3,24};AccountKey=[A-Za-z0-9+/=]{20,}(?:;EndpointSuffix=[A-Za-z0-9.-]+)?(?=$|[\\s,.;)])~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AZURE_STORAGE_CONNECTION_STRING
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AZURE_STORAGE_CONNECTION_STRING;
    }
}
