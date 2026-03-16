<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Ipv6 Cidr values from text.
 *
 * Examples:
 * - valid: `2001:db8:85a3:0:0:8a2e:370:7334/64`
 * - invalid: `2001:db8::1`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:[A-F0-9]{1,4}:){2,7}[A-F0-9]{1,4}\/(?:12[0-8]|1[01]\d|\d?\d)\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class Ipv6CidrProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:[A-F0-9]{1,4}:){2,7}[A-F0-9]{1,4}\/(?:12[0-8]|1[01]\d|\d?\d)\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IPV6_CIDR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IPV6_CIDR;
    }
}
