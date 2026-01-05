<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Access-Control-Allow-Credentials headers.
 */
class CorsAllowCredentialsProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^Access-Control-Allow-Credentials:\s*(?:true|false)$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CORS_ALLOW_CREDENTIALS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CORS_ALLOW_CREDENTIALS;
    }
}
