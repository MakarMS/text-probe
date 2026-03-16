<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Correlation Id values from text.
 *
 * Examples:
 * - valid: `9f1d7c1a8b3e4d2f`
 * - invalid: `corr-id`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:[A-F0-9]{16}|[A-F0-9]{32}|[0-9a-f]{8}-[0-9a-f-]{27})\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class CorrelationIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:[A-F0-9]{16}|[A-F0-9]{32}|[0-9a-f]{8}-[0-9a-f-]{27})\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORRELATION_ID
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORRELATION_ID;
    }
}
