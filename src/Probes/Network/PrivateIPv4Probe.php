<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts private IPv4 addresses from text.
 *
 * Supported ranges:
 * - 10.0.0.0/8
 * - 172.16.0.0/12 (172.16.0.0 – 172.31.255.255)
 * - 192.168.0.0/16
 *
 * The regex mirrors {@see IPv4Probe} lookarounds to avoid matching substrings
 * inside longer numeric tokens or malformed addresses while restricting octets
 * to the private address blocks.
 */
class PrivateIPv4Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $octet = '(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)';

        return $this->findByRegex(
            '/(?<![\d.])'
            . '('
            . '10\.' . $octet . '\.' . $octet . '\.' . $octet
            . '|172\.(?:1[6-9]|2\d|3[0-1])\.' . $octet . '\.' . $octet
            . '|192\.168\.' . $octet . '\.' . $octet
            . ')'
            . '\b(?!\.\d)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::PRIVATE_IPV4
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PRIVATE_IPV4;
    }
}
