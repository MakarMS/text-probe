<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Kubernetes resource names.
 */
class KubernetesResourceNameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,253}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?(\.[a-z0-9]([-a-z0-9]*[a-z0-9])?)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_RESOURCE_NAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_RESOURCE_NAME;
    }
}
