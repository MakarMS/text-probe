<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts base64url-style CSRF tokens.
 *
 * Matches tokens made of base64url characters with a minimum length of 20.
 */
class CsrfTokenBase64UrlProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Za-z0-9_-]{20,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CSRF_TOKEN_BASE64URL
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CSRF_TOKEN_BASE64URL;
    }
}
