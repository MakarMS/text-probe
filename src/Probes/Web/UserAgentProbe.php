<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts HTTP User-Agent strings from text.
 *
 * This probe targets typical User-Agent header patterns composed of product
 * tokens (e.g. "Mozilla/5.0", "Chrome/119.0.0.0") and optional comments in
 * parentheses, allowing multiple tokens and complex structures as commonly
 * seen in browser and crawler identifiers.
 */
class UserAgentProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b([a-z][\w-]*\/[\w.-]+(?:\s*(?:[a-z][\w-]*\/[\w.-]+|\( [^)]+ \)))*)/ixu',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::USER_AGENT
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::USER_AGENT;
    }
}
