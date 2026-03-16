<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts OAuth refresh tokens in JWT or opaque form.
 */
class OAuthRefreshTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $jwt = '[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+';
        $opaque = '[A-Za-z0-9_-]{20,}';
        $pattern = '(?<![A-Za-z0-9_-])(?:' . $jwt . '|' . $opaque . ')(?![A-Za-z0-9_-])';

        return $this->findByRegex('~' . $pattern . '~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OAUTH_REFRESH_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OAUTH_REFRESH_TOKEN;
    }
}
