<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts HTTP Basic auth base64 blobs.
 *
 * Uses the same matching rules as {@see BasicAuthBase64Probe}.
 */
class BasicAuthProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~(?<![A-Za-z0-9+/=])[A-Za-z0-9+/]{8,}={0,2}(?![A-Za-z0-9+/=])~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BASIC_AUTH
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BASIC_AUTH;
    }
}
