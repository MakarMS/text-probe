<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Google API keys.
 *
 * Matches keys starting with AIza followed by base64url-ish characters.
 */
class GoogleApiKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bAIza[0-9A-Za-z\-_]{30,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GOOGLE_API_KEY
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GOOGLE_API_KEY;
    }
}
