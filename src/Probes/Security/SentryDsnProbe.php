<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Sentry Dsn values from text.
 *
 * Examples:
 * - valid: `https://abcdef123456@example.ingest.sentry.io/12345`
 * - invalid: `sentry://dsn`
 *
 * Constraints:
 * - Uses regex pattern `~https?://[0-9a-f]+@[A-Za-z0-9.-]+/\d+\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class SentryDsnProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://[0-9a-f]+@[A-Za-z0-9.-]+/\d+\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SENTRY_DSN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SENTRY_DSN;
    }
}
