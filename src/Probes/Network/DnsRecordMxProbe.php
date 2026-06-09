<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts DNS MX record lines.
 *
 * Examples:
 * - valid: `example.com. 3600 IN MX 10 mail.example.com.`
 * - valid: `example.com MX 5 mx.example.net`
 *
 * Constraints:
 * - Matches one owner, optional TTL/`IN`, a 1-5 digit preference, and one exchange hostname. It does not enforce the 0-65535 preference range, validate hostname label lengths, or check that the mail exchanger exists.
 * - Uses regex pattern `/(?mi)^\S+\.?\h+(?:\d+\h+)?(?:IN\h+)?MX\h+\d{1,5}\h+[A-Za-z0-9.-]+\.?$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DnsRecordMxProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^\\S+\\.?\\h+(?:\\d+\\h+)?(?:IN\\h+)?MX\\h+\\d{1,5}\\h+[A-Za-z0-9.-]+\\.?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DNS_RECORD_MX
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DNS_RECORD_MX;
    }
}
