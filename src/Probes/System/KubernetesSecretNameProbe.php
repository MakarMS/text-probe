<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Kubernetes secret names.
 *
 * Examples:
 * - valid: `db-password`
 * - valid: `tls.secret`
 *
 * Constraints:
 * - Matches DNS subdomain-style Secret names up to 253 characters. It identifies names, not secret values; it does not query a cluster, decode Kubernetes Secret data, or verify that a Secret exists.
 * - Uses regex pattern `/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesSecretNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_SECRET_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_SECRET_NAME;
    }
}
