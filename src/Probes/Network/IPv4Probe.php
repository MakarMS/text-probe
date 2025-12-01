<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts IPv4 addresses from text.
 *
 * This probe matches dotted-quad IPv4 addresses (0.0.0.0–255.255.255.255),
 * using negative lookbehinds/aheads to avoid matching parts of longer numeric
 * strings or malformed values.
 */
class IPv4Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![\d.])'
            . '((?:(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.){3}'
            . '(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d))'
            . '\b(?!\.\d)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::IPV4
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IPV4;
    }
}
