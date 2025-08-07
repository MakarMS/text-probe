<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class MacAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $regex = '/(?<![0-9A-Fa-f:-])(?:[0-9A-Fa-f]{2}([-:])){5}[0-9A-Fa-f]{2}(?![0-9A-Fa-f:-])/';

        return $this->findByRegex($regex, $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MAC_ADDRESS;
    }
}
