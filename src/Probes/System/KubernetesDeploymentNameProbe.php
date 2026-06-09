<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Kubernetes deployment names.
 *
 * Examples:
 * - valid: `api-deployment`
 * - valid: `web.prod`
 *
 * Constraints:
 * - Matches DNS subdomain-style names up to 253 characters, including dot-separated labels. It does not inspect manifests, check `kind: Deployment`, or query a cluster.
 * - Uses regex pattern `/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesDeploymentNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_DEPLOYMENT_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_DEPLOYMENT_NAME;
    }
}
