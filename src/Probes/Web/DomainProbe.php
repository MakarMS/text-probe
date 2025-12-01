<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts domain names from text.
 *
 * This probe supports ASCII and internationalised (Unicode/IDN) domains,
 * including multi-level subdomains and TLDs with a minimum length of two
 * characters.
 */
class DomainProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b((?:[\p{L}0-9-]+\.)+\p{L}{2,})\b/u', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DOMAIN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOMAIN;
    }
}
