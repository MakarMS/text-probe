<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Access-Control-Expose-Headers headers.
 */
class CorsExposeHeadersProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^Access-Control-Expose-Headers:\s*[A-Za-z0-9-]+(?:\s*,\s*[A-Za-z0-9-]+)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORS_EXPOSE_HEADERS
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORS_EXPOSE_HEADERS;
    }
}
