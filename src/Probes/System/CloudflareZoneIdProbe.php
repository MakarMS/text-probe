<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Cloudflare Zone Id values from text.
 *
 * Examples:
 * - valid: `023e105f4ecef8ad9ca31a8372d0c353`
 * - invalid: `023e105f4ecef8ad`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-f0-9]{32}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class CloudflareZoneIdProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-f0-9]{32}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CLOUDFLARE_ZONE_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CLOUDFLARE_ZONE_ID;
    }
}
