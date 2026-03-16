<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Kubernetes Annotation Key values from text.
 *
 * Examples:
 * - valid: `example.com/owner`
 * - invalid: `owner/`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z0-9](?:[-a-z0-9]*[a-z0-9])?(?:\.[a-z0-9](?:[-a-z0-9]*[a-z0-9])?)*\/[A-Za-z0-9](?:[-.A-Za-z0-9]*[A-Za-z0-9])\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesAnnotationKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z0-9](?:[-a-z0-9]*[a-z0-9])?(?:\.[a-z0-9](?:[-a-z0-9]*[a-z0-9])?)*\/[A-Za-z0-9](?:[-.A-Za-z0-9]*[A-Za-z0-9])\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_ANNOTATION_KEY
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_ANNOTATION_KEY;
    }
}
