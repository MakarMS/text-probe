<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Access-Control-Max-Age headers.
 */
class CorsMaxAgeProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^Access-Control-Max-Age:\s*\d+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORS_MAX_AGE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORS_MAX_AGE;
    }
}
