<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts New Relic License Key values from text.
 *
 * Examples:
 * - valid: `1234567890abcdef1234567890abcdef12345678`
 * - invalid: `1234`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9a-f]{40}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class NewRelicLicenseKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{40}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NEW_RELIC_LICENSE_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NEW_RELIC_LICENSE_KEY;
    }
}
