<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Prometheus label sets.
 *
 * Examples:
 * - valid: `{method="GET",code="200"}`
 * - valid: `{job="api"}`
 *
 * Constraints:
 * - Matches compact `{label="value",...}` sets with identifier-style label names and double-quoted values. It does not parse PromQL fully, allow spaces around separators, validate reserved labels, or evaluate escaped values semantically.
 * - Uses regex pattern `/\{[a-zA-Z_][a-zA-Z0-9_]*="[^"\\]*(?:\\.[^"\\]*)*"(?:,[a-zA-Z_][a-zA-Z0-9_]*="[^"\\]*(?:\\.[^"\\]*)*")*\}/`.
 * - Relies on regex filtering only (no additional validator).
 */
class PrometheusLabelSetProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\{[a-zA-Z_][a-zA-Z0-9_]*="[^"\\\\]*(?:\\\\.[^"\\\\]*)*"(?:,[a-zA-Z_][a-zA-Z0-9_]*="[^"\\\\]*(?:\\\\.[^"\\\\]*)*")*\\}/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PROMETHEUS_LABEL_SET
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PROMETHEUS_LABEL_SET;
    }
}
