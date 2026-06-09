<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Prometheus metric names.
 *
 * Examples:
 * - valid: `http_requests_total`
 * - valid: `node:cpu_seconds:sum`
 *
 * Constraints:
 * - Follows Prometheus metric-name characters: letters, digits, underscore, and colon, with a non-digit first character. This is intentionally broad, so ordinary words like `status` or `error` can match; it does not query Prometheus or validate metric availability.
 * - Uses regex pattern `/\b[a-zA-Z_:][a-zA-Z0-9_:]*\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class PrometheusMetricNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[a-zA-Z_:][a-zA-Z0-9_:]*\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PROMETHEUS_METRIC_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PROMETHEUS_METRIC_NAME;
    }
}
