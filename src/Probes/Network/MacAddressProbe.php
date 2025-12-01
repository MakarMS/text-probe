<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts MAC addresses from text.
 *
 * This probe matches standard MAC formats using colons or hyphens
 * (e.g. "00:1A:2B:3C:4D:5E" or "00-1A-2B-3C-4D-5E"), and uses lookarounds
 * to avoid matching substrings inside longer hexadecimal tokens.
 */
class MacAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![0-9A-Fa-f:-])(?:[0-9A-Fa-f]{2}([-:])){5}[0-9A-Fa-f]{2}(?![0-9A-Fa-f:-])/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::MAC_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MAC_ADDRESS;
    }
}
