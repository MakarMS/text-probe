<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class UserAgentProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b([a-z][\w-]*\/[\w.-]+(?:\s*(?:[a-z][\w-]*\/[\w.-]+|\( [^)]+ \)))*)/ixu',
            $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::USER_AGENT;
    }
}
