<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts query strings with multiple parameters.
 */
class QueryStringProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\?[A-Za-z0-9_-]{1,64}=[^\s&]*(?:&[A-Za-z0-9_-]{1,64}=[^\s&]*)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::QUERY_STRING
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::QUERY_STRING;
    }
}
