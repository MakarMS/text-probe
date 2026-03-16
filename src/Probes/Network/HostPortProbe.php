<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Host Port values from text.
 *
 * Examples:
 * - valid: `api.example.com:8443`
 * - invalid: `api.example.com`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:[A-Za-z0-9.-]+|(?:25[0-5]|2[0-4]\d|1?\d?\d)(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){3}):(?:6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]?\d{1,4})\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class HostPortProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:[A-Za-z0-9.-]+|(?:25[0-5]|2[0-4]\d|1?\d?\d)(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){3}):(?:6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]?\d{1,4})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HOST_PORT
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HOST_PORT;
    }
}
