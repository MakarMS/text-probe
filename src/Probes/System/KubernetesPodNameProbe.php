<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Kubernetes Pod Name values from text.
 *
 * Examples:
 * - valid: `api-server-7d9f6c8b4d`
 * - invalid: `Api_Server`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z0-9](?:[-a-z0-9]*[a-z0-9])?(?:-[a-z0-9]{5,10})\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesPodNameProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z0-9](?:[-a-z0-9]*[a-z0-9])?(?:-[a-z0-9]{5,10})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_POD_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_POD_NAME;
    }
}
