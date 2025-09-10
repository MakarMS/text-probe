<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class DomainProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b((?:[\p{L}0-9-]+\.)+\p{L}{2,})\b/u', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOMAIN;
    }
}
