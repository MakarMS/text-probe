<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Grafana dashboard URLs.
 *
 * Examples:
 * - valid: `https://grafana.example.com/d/abc123/service`
 * - valid: `http://localhost:3000/d/node_exporter`
 *
 * Constraints:
 * - Requires an absolute `http` or `https` URL containing `/d/{dashboard_uid}`. It does not call Grafana, verify dashboard existence, parse query parameters, or require a specific Grafana host.
 * - Uses regex pattern `~\bhttps?://[^\s<>"]+/d/[A-Za-z0-9_-]+(?:/[^\s<>",)]*)?~`.
 * - Relies on regex filtering only (no additional validator).
 */
class GrafanaDashboardUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bhttps?://[^\\s<>"]+/d/[A-Za-z0-9_-]+(?:/[^\\s<>",)]*)?~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GRAFANA_DASHBOARD_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GRAFANA_DASHBOARD_URL;
    }
}
