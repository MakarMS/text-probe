<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Access-Control-Allow-Methods headers.
 */
class CorsAllowMethodsProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^Access-Control-Allow-Methods:\s*[A-Z]+(?:\s*,\s*[A-Z]+)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORS_ALLOW_METHODS
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORS_ALLOW_METHODS;
    }
}
