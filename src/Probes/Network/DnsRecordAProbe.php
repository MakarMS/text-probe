<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts DNS A record lines.
 *
 * Examples:
 * - valid: `example.com. 3600 IN A 192.0.2.1`
 * - valid: `www.example.com A 203.0.113.10`
 *
 * Constraints:
 * - Matches a single zone-file-style line with optional TTL and optional `IN`. The IPv4 address octets are constrained to 0-255, but the probe does not resolve DNS, validate owner-name length, or parse multiline zone files.
 * - Uses regex pattern `/(?mi)^\S+\.?\h+(?:\d+\h+)?(?:IN\h+)?A\h+(?:25[0-5]|2[0-4]\d|1?\d?\d)(?:\.(?:25[0-5]|2[0-4]\d|1?\d?\d)){3}$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DnsRecordAProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^\\S+\\.?\\h+(?:\\d+\\h+)?(?:IN\\h+)?A\\h+(?:25[0-5]|2[0-4]\\d|1?\\d?\\d)(?:\\.(?:25[0-5]|2[0-4]\\d|1?\\d?\\d)){3}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DNS_RECORD_A
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DNS_RECORD_A;
    }
}
