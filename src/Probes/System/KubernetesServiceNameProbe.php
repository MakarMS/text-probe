<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Kubernetes service names.
 *
 * Examples:
 * - valid: `api-service`
 * - valid: `web2`
 *
 * Constraints:
 * - Matches RFC 1123 label-style names up to 63 characters: lowercase letters, digits, hyphens, and alphanumeric start/end. It does not inspect a cluster or confirm that the Service resource exists.
 * - Uses regex pattern `/(?m)^(?=.{1,63}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesServiceNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,63}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_SERVICE_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_SERVICE_NAME;
    }
}
