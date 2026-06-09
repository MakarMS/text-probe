<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts DNS TXT record lines.
 *
 * Examples:
 * - valid: `example.com. 3600 IN TXT "v=spf1 include:_spf.example.com ~all"`
 * - valid: `example.com TXT "google-site-verification=abc123"`
 *
 * Constraints:
 * - Requires a single double-quoted TXT string on one line. It does not handle split TXT chunks, escaped quotes, parentheses, multiline records, DNS lookups, or SPF/DMARC semantic validation.
 * - Uses regex pattern `/(?mi)^\S+\.?\h+(?:\d+\h+)?(?:IN\h+)?TXT\h+"[^"\r\n]*"$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DnsRecordTxtProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^\\S+\\.?\\h+(?:\\d+\\h+)?(?:IN\\h+)?TXT\\h+"[^"\\r\\n]*"$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DNS_RECORD_TXT
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DNS_RECORD_TXT;
    }
}
