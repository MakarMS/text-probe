<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Sentry event IDs.
 *
 * Examples:
 * - valid: `0123456789abcdef0123456789abcdef`
 * - valid: `abcdefabcdefabcdefabcdefabcdefab`
 *
 * Constraints:
 * - Accepts any 32-character hexadecimal token. It does not query Sentry, verify project ownership, or distinguish event IDs from other UUID-without-dashes or hash-like values.
 * - Uses regex pattern `/\b[0-9a-f]{32}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class SentryEventIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[0-9a-f]{32}\\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SENTRY_EVENT_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SENTRY_EVENT_ID;
    }
}
