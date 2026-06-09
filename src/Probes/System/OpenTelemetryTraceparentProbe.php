<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts W3C traceparent headers.
 *
 * Examples:
 * - valid: `00-4bf92f3577b34da6a3ce929d0e0e4736-00f067aa0ba902b7-01`
 * - valid: `00-aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-bbbbbbbbbbbbbbbb-00`
 *
 * Constraints:
 * - Matches the four hyphen-separated lowercase hexadecimal fields by length. It does not enforce W3C invalid all-zero trace/span IDs, version-specific rules, or trace existence in a backend.
 * - Uses regex pattern `/\b[0-9a-f]{2}-[0-9a-f]{32}-[0-9a-f]{16}-[0-9a-f]{2}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class OpenTelemetryTraceparentProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[0-9a-f]{2}-[0-9a-f]{32}-[0-9a-f]{16}-[0-9a-f]{2}\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OPENTELEMETRY_TRACEPARENT
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OPENTELEMETRY_TRACEPARENT;
    }
}
