<?php

namespace TextProbe\Probes\DateTime;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Unix Epoch Timestamp values from text.
 *
 * Examples:
 * - valid: `1710567890`
 * - invalid: `171056789`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:1\d{9}|1\d{12})\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class UnixEpochTimestampProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:1\d{9}|1\d{12})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UNIX_EPOCH_TIMESTAMP
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UNIX_EPOCH_TIMESTAMP;
    }
}
