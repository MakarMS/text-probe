<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts DNS AAAA record lines.
 *
 * Examples:
 * - valid: `example.com. 3600 IN AAAA 2001:db8::1`
 * - valid: `www.example.com AAAA 2001:db8:0:0:0:0:0:2`
 *
 * Constraints:
 * - Matches a single line with optional TTL and optional `IN`, then an IPv6-looking value made of hex digits and colons. It does not fully validate IPv6 compression rules, resolve DNS, or parse multiline zone files.
 * - Uses regex pattern `/(?mi)^\S+\.?\h+(?:\d+\h+)?(?:IN\h+)?AAAA\h+[0-9A-Fa-f:]{2,}$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DnsRecordAaaaProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^\\S+\\.?\\h+(?:\\d+\\h+)?(?:IN\\h+)?AAAA\\h+[0-9A-Fa-f:]{2,}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DNS_RECORD_AAAA
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DNS_RECORD_AAAA;
    }
}
