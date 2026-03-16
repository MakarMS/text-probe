<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts UUID-shaped CSRF tokens.
 *
 * Matches UUIDs with versions 1-8 and RFC 4122 variant bits.
 */
class CsrfTokenUuidProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $pattern = '\\b[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-8][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}\\b';

        return $this->findByRegex('/' . $pattern . '/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CSRF_TOKEN_UUID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CSRF_TOKEN_UUID;
    }
}
