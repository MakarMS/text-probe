<?php

namespace TextProbe\Probes\DateTime;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Log Timestamp Iso8601 values from text.
 *
 * Examples:
 * - valid: `2026-03-16T12:30:45Z`
 * - invalid: `16-03-2026 12:30:45`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:Z|[+\-]\d{2}:\d{2})\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class LogTimestampIso8601Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:Z|[+\-]\d{2}:\d{2})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LOG_TIMESTAMP_ISO8601
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LOG_TIMESTAMP_ISO8601;
    }
}
