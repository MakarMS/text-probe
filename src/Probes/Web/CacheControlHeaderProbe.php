<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Cache-Control headers.
 *
 * Examples:
 * - valid: `Cache-Control: no-cache`
 * - valid: `Cache-Control: public, max-age=3600`
 *
 * Constraints:
 * - Matches comma-separated directive names with optional simple values. It does not enforce directive compatibility, support every quoted value edge case, or evaluate response freshness.
 * - Uses regex pattern `/(?mi)^Cache-Control:\h*[A-Za-z][A-Za-z-]*(?:=?[A-Za-z0-9"._-]+)?(?:\h*,\h*[A-Za-z][A-Za-z-]*(?:=?[A-Za-z0-9"._-]+)?)*$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class CacheControlHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^Cache-Control:\\h*[A-Za-z][A-Za-z-]*(?:=?[A-Za-z0-9"._-]+)?(?:\\h*,\\h*[A-Za-z][A-Za-z-]*(?:=?[A-Za-z0-9"._-]+)?)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CACHE_CONTROL_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CACHE_CONTROL_HEADER;
    }
}
