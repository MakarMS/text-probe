<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Helm chart names in repository/chart form.
 *
 * Examples:
 * - valid: `bitnami/nginx`
 * - valid: `company/app-chart`
 *
 * Constraints:
 * - Requires `repository/chart` with lowercase DNS-label-like segments. It does not query Helm repositories, validate chart versions, or parse full chart references with OCI prefixes.
 * - Uses regex pattern `/\b[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\/[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class HelmChartNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\\/[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HELM_CHART_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HELM_CHART_NAME;
    }
}
