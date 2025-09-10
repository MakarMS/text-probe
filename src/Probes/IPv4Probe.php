<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;

class IPv4Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![\d.])'
            . '((?:(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.){3}'
            . '(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d))'
            . '\b(?!\.\d)/',
            $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IPV4;
    }
}