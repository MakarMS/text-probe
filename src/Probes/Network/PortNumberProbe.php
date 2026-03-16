<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Port Number values from text.
 *
 * Examples:
 * - valid: `443`
 * - invalid: `70000`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]?\d{1,4})\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class PortNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]?\d{1,4})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PORT_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PORT_NUMBER;
    }
}
