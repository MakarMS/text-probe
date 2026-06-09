<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Jaeger trace IDs.
 *
 * Examples:
 * - valid: `4bf92f3577b34da6`
 * - valid: `4bf92f3577b34da6a3ce929d0e0e4736`
 *
 * Constraints:
 * - Accepts lowercase 16- or 32-character hexadecimal IDs. It does not accept uppercase IDs, reject all-zero IDs, or query Jaeger/Tempo storage.
 * - Uses regex pattern `/\b[0-9a-f]{16}(?:[0-9a-f]{16})?\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class JaegerTraceIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[0-9a-f]{16}(?:[0-9a-f]{16})?\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JAEGER_TRACE_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JAEGER_TRACE_ID;
    }
}
