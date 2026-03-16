<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts OAuth access tokens in JWT form.
 */
class OAuthAccessTokenJwtProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $pattern = '(?<![A-Za-z0-9_-])[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+(?![A-Za-z0-9_-])';

        return $this->findByRegex('~' . $pattern . '~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OAUTH_ACCESS_TOKEN_JWT
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OAUTH_ACCESS_TOKEN_JWT;
    }
}
