<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts 40-character Cloudflare API token candidates.
 *
 * Examples:
 * - valid: `abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN`
 * - valid: `1234567890abcdefghijklmnopqrstuvwxyzABCD`
 *
 * Constraints:
 * - Accepts any 40-character alphanumeric, underscore, or hyphen token. Because there is no provider prefix, unrelated 40-character IDs can match; it does not call Cloudflare or verify scopes.
 * - Uses regex pattern `~\b[A-Za-z0-9_-]{40}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class CloudflareApiTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b[A-Za-z0-9_-]{40}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CLOUDFLARE_API_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CLOUDFLARE_API_TOKEN;
    }
}
