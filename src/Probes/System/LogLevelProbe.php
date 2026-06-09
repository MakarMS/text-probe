<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts common log level tokens.
 *
 * Examples:
 * - valid: `ERROR`
 * - valid: `WARNING`
 *
 * Constraints:
 * - Matches uppercase `TRACE`, `DEBUG`, `INFO`, `NOTICE`, `WARN`, `WARNING`, `ERROR`, `CRITICAL`, `ALERT`, and `EMERGENCY`. It does not infer severity from messages or support lowercase tokens.
 * - Uses regex pattern `/\b(?:TRACE|DEBUG|INFO|NOTICE|WARN|WARNING|ERROR|CRITICAL|ALERT|EMERGENCY)\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class LogLevelProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?:TRACE|DEBUG|INFO|NOTICE|WARN|WARNING|ERROR|CRITICAL|ALERT|EMERGENCY)\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LOG_LEVEL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LOG_LEVEL;
    }
}
