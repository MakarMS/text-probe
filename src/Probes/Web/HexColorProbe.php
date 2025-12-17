<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts hexadecimal color codes from text.
 *
 * Supports short (3-digit) and full (6-digit) CSS hex formats such as
 * "#fff" or "#1a2b3c", while avoiding longer hexadecimal tokens by using
 * lookarounds around the match.
 */
class HexColorProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![0-9A-Fa-f])#(?:[0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})(?![0-9A-Fa-f])/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::HEX_COLOR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HEX_COLOR;
    }
}
