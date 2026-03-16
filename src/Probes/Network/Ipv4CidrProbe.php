<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Ipv4 Cidr values from text.
 *
 * Examples:
 * - valid: `10.0.0.0/24`
 * - invalid: `10.0.0.0`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:25[0-5]|2[0-4]\d|1?\d?\d)(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){3}\/(?:3[0-2]|[12]?\d)\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class Ipv4CidrProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:25[0-5]|2[0-4]\d|1?\d?\d)(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){3}\/(?:3[0-2]|[12]?\d)\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IPV4_CIDR
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IPV4_CIDR;
    }
}
