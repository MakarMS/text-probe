<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts base64 blobs commonly used in HTTP Basic auth.
 *
 * Matches base64 strings of at least 8 characters with optional padding.
 */
class BasicAuthBase64Probe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~(?<![A-Za-z0-9+/=])[A-Za-z0-9+/]{8,}={0,2}(?![A-Za-z0-9+/=])~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BASIC_AUTH_BASE64
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BASIC_AUTH_BASE64;
    }
}
