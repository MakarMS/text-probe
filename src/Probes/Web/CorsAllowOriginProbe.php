<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Access-Control-Allow-Origin headers.
 */
class CorsAllowOriginProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^Access-Control-Allow-Origin:\s*.+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORS_ALLOW_ORIGIN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORS_ALLOW_ORIGIN;
    }
}
