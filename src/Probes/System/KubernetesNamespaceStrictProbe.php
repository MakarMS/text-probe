<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Kubernetes namespaces (DNS label).
 */
class KubernetesNamespaceStrictProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,63}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_NAMESPACE_STRICT
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_NAMESPACE_STRICT;
    }
}
