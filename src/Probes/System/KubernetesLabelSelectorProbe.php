<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Kubernetes Label Selector values from text.
 *
 * Examples:
 * - valid: `app=api,tier=web`
 * - invalid: `app-api`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z0-9_.-]+=[a-zA-Z0-9_.-]+(?:,[a-zA-Z0-9_.-]+=[a-zA-Z0-9_.-]+)*\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesLabelSelectorProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z0-9_.-]+=[a-zA-Z0-9_.-]+(?:,[a-zA-Z0-9_.-]+=[a-zA-Z0-9_.-]+)*\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_LABEL_SELECTOR
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_LABEL_SELECTOR;
    }
}
