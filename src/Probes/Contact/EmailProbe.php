<?php

namespace TextProbe\Probes\Contact;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class EmailProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EMAIL;
    }
}