<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts opaque bearer tokens.
 *
 * Matches base62/base64url-like token strings with a minimum length of 20.
 */
class OpaqueTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $pattern = '(?<![A-Za-z0-9_-])[A-Za-z0-9_-]{20,}(?![A-Za-z0-9_-])';

        return $this->findByRegex('~' . $pattern . '~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OPAQUE_TOKEN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OPAQUE_TOKEN;
    }
}
