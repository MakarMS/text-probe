<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Kubernetes DNS labels.
 */
class K8sDnsLabelProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^(?=.{1,63}$)[a-z0-9]([-a-z0-9]*[a-z0-9])?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::K8S_DNS_LABEL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::K8S_DNS_LABEL;
    }
}
