<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts CSRF tokens in hex, base64url, or UUID form.
 */
class CsrfTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $hex = '[a-fA-F0-9]{32,128}';
        $base64Url = '[A-Za-z0-9_-]{20,}';
        $uuid = '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-8][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}';

        return $this->findByRegex('/\b(?:' . $hex . '|' . $base64Url . '|' . $uuid . ')\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CSRF_TOKEN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CSRF_TOKEN;
    }
}
