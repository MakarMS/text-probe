<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts W3C tracestate values.
 *
 * Examples:
 * - valid: `rojo=00f067aa0ba902b7`
 * - valid: `vendor=value,congo=t61rcWkgMzE`
 *
 * Constraints:
 * - Matches comma-separated `key=value` pairs without whitespace in values. It does not enforce all W3C key/vendor limits, maximum member count, ordering semantics, or backend trace existence.
 * - Uses regex pattern `~\b[a-z][a-z0-9_*\/-]*=[^,\s]+(?:,[a-z][a-z0-9_*\/-]*=[^,\s]+)*\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class OpenTelemetryTracestateProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b[a-z][a-z0-9_*/-]*=[^,\\s]+(?:,[a-z][a-z0-9_*/-]*=[^,\\s]+)*\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OPENTELEMETRY_TRACESTATE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OPENTELEMETRY_TRACESTATE;
    }
}
