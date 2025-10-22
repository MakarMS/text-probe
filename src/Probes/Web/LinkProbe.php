<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class LinkProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?:'
            . 'https?:\/\/(?:\[[0-9a-f:.]+]|\d{1,3}(?:\.\d{1,3}){3}|(?:[a-z0-9-]+\.)+[a-z]{2,})\S*'
            . '|'
            . '(?:www\.|(?:[a-z0-9-]+\.)+[a-z]{2,})(?:\/\S*)?'
            . ')(?<![.,;:!?\s])/i',
            $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LINK;
    }
}
