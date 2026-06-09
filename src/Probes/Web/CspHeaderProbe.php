<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Content-Security-Policy headers.
 *
 * Examples:
 * - valid: `Content-Security-Policy: default-src 'self'`
 * - valid: `Content-Security-Policy: frame-ancestors none`
 *
 * Constraints:
 * - Matches any non-empty `Content-Security-Policy:` line. It does not parse directives, validate source expressions, detect unsafe policies, or merge multiple CSP headers.
 * - Uses regex pattern `/(?mi)^Content-Security-Policy:\h*[^\r\n]+$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class CspHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^Content-Security-Policy:\\h*[^\\r\\n]+$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CSP_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CSP_HEADER;
    }
}
