<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts DNS CNAME record lines.
 *
 * Examples:
 * - valid: `www.example.com. 3600 IN CNAME example.com.`
 * - valid: `cdn.example.com CNAME edge.example.net`
 *
 * Constraints:
 * - Matches one owner, optional TTL/`IN`, and one target hostname on a single line. It does not enforce CNAME exclusivity rules, validate full DNS label constraints, or resolve the target.
 * - Uses regex pattern `/(?mi)^\S+\.?\h+(?:\d+\h+)?(?:IN\h+)?CNAME\h+[A-Za-z0-9.-]+\.?$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DnsRecordCnameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^\\S+\\.?\\h+(?:\\d+\\h+)?(?:IN\\h+)?CNAME\\h+[A-Za-z0-9.-]+\\.?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DNS_RECORD_CNAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DNS_RECORD_CNAME;
    }
}
