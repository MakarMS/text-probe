<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts DNS SRV record lines.
 *
 * Examples:
 * - valid: `_sip._tcp.example.com. 3600 IN SRV 10 60 5060 sip.example.com.`
 * - valid: `_xmpp._tcp.example.com SRV 5 0 5222 xmpp.example.com`
 *
 * Constraints:
 * - Expects priority, weight, port, and target on one line after `SRV`. It does not enforce numeric ranges, service/protocol naming semantics, target existence, or multiline zone syntax.
 * - Uses regex pattern `/(?mi)^_[A-Za-z0-9-]+\._(?:tcp|udp)\.[A-Za-z0-9.-]+\.?\h+(?:\d+\h+)?(?:IN\h+)?SRV\h+\d{1,5}\h+\d{1,5}\h+\d{1,5}\h+[A-Za-z0-9.-]+\.?$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DnsSrvRecordProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^_[A-Za-z0-9-]+\\._(?:tcp|udp)\\.[A-Za-z0-9.-]+\\.?\\h+(?:\\d+\\h+)?(?:IN\\h+)?SRV\\h+\\d{1,5}\\h+\\d{1,5}\\h+\\d{1,5}\\h+[A-Za-z0-9.-]+\\.?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DNS_SRV_RECORD
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DNS_SRV_RECORD;
    }
}
