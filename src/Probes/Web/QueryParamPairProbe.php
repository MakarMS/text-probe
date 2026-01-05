<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts query parameter key/value pairs.
 */
class QueryParamPairProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Za-z0-9_-]{1,64}=[^\s&]*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::QUERY_PARAM_PAIR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::QUERY_PARAM_PAIR;
    }
}
