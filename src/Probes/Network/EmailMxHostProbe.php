<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts common mail exchanger hostnames.
 *
 * Examples:
 * - valid: `mx1.example.com`
 * - valid: `aspmx.l.google.com`
 *
 * Constraints:
 * - Detects hostnames that start with common mail prefixes such as `mx`, `mail`, or `aspmx`. It can miss valid MX hosts with different naming conventions and does not resolve DNS or verify mail routing.
 * - Uses regex pattern `/\b(?:mx|mail|aspmx)[A-Za-z0-9.-]*\.[A-Za-z]{2,}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class EmailMxHostProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?:mx|mail|aspmx)[A-Za-z0-9.-]*\\.[A-Za-z]{2,}\\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::EMAIL_MX_HOST
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EMAIL_MX_HOST;
    }
}
