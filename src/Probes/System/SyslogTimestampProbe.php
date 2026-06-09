<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts traditional syslog timestamps.
 *
 * Examples:
 * - valid: `Jan  2 03:04:05`
 * - valid: `Dec 31 23:59:59`
 *
 * Constraints:
 * - Matches BSD-style `Mon DD HH:MM:SS` timestamps with English month names. It does not validate calendar dates, leap seconds, timezone, year, or full RFC 5424 structured messages.
 * - Uses regex pattern `/\b(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\h+\d{1,2}\h+\d{2}:\d{2}:\d{2}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class SyslogTimestampProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\\h+\\d{1,2}\\h+\\d{2}:\\d{2}:\\d{2}\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SYSLOG_TIMESTAMP
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SYSLOG_TIMESTAMP;
    }
}
