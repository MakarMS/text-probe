<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts bearer token strings without the "Bearer" prefix.
 *
 * Matches either JWT tokens (three base64url segments) or opaque tokens with
 * base64url-like characters.
 */
class BearerTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $jwt = '[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+';
        $opaque = '[A-Za-z0-9_-]{20,}';
        $pattern = '(?<![A-Za-z0-9_-])(?:' . $jwt . '|' . $opaque . ')(?![A-Za-z0-9_-])';

        return $this->findByRegex('~' . $pattern . '~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BEARER_TOKEN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BEARER_TOKEN;
    }
}
