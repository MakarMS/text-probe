<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Access-Control-Allow-Headers headers.
 */
class CorsAllowHeadersProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^Access-Control-Allow-Headers:\s*[A-Za-z0-9-]+(?:\s*,\s*[A-Za-z0-9-]+)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORS_ALLOW_HEADERS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORS_ALLOW_HEADERS;
    }
}
