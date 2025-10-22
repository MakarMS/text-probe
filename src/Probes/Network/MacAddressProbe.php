<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class MacAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![0-9A-Fa-f:-])(?:[0-9A-Fa-f]{2}([-:])){5}[0-9A-Fa-f]{2}(?![0-9A-Fa-f:-])/',
            $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MAC_ADDRESS;
    }
}
