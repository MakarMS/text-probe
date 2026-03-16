<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts OAuth refresh tokens in JWT form.
 */
class OAuthRefreshTokenJwtProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $pattern = '(?<![A-Za-z0-9_-])[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+(?![A-Za-z0-9_-])';

        return $this->findByRegex('~' . $pattern . '~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OAUTH_REFRESH_TOKEN_JWT
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OAUTH_REFRESH_TOKEN_JWT;
    }
}
