<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Kubernetes ConfigMap names.
 *
 * Examples:
 * - valid: `app-config`
 * - valid: `service.config`
 *
 * Constraints:
 * - Matches DNS subdomain-style ConfigMap names up to 253 characters. It does not inspect manifests, read ConfigMap keys, or query a cluster.
 * - Uses regex pattern `/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesConfigMapNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_CONFIG_MAP_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_CONFIG_MAP_NAME;
    }
}
