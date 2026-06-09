<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts syslog priority values.
 *
 * Examples:
 * - valid: `<34>`
 * - valid: `<191>`
 *
 * Constraints:
 * - Matches one to three digits inside angle brackets. It does not enforce the syslog PRI range of 0-191 or split facility and severity values.
 * - Uses regex pattern `/<\d{1,3}>/`.
 * - Relies on regex filtering only (no additional validator).
 */
class SyslogPriorityProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/<\\d{1,3}>/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SYSLOG_PRIORITY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SYSLOG_PRIORITY;
    }
}
