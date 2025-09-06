<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class HashtagProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/#[\p{L}\p{M}0-9_]+/u', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HASHTAG;
    }
}