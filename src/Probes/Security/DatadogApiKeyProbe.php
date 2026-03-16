<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Datadog Api Key values from text.
 *
 * Examples:
 * - valid: `1234567890abcdef1234567890abcdef`
 * - invalid: `123456`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9a-f]{32}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class DatadogApiKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{32}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DATADOG_API_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DATADOG_API_KEY;
    }
}
