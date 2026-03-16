<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Socket Address values from text.
 *
 * Examples:
 * - valid: `[2001:db8::1]:443`
 * - invalid: `2001:db8::1`
 *
 * Constraints:
 * - Uses regex pattern `/(?:\[[A-F0-9:]+\]|[A-Za-z0-9.-]+):(?:6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]?\d{1,4})/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class SocketAddressProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?:\[[A-F0-9:]+\]|[A-Za-z0-9.-]+):(?:6553[0-5]|655[0-2]\d|65[0-4]\d{2}|6[0-4]\d{3}|[1-5]?\d{1,4})/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SOCKET_ADDRESS
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SOCKET_ADDRESS;
    }
}
