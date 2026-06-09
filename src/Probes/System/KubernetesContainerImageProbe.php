<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts tagged Kubernetes container image references.
 *
 * Examples:
 * - valid: `registry.example.com/app/api:v1`
 * - valid: `ghcr.io/org/service:2024.01`
 *
 * Constraints:
 * - Requires an image path with at least one slash and an explicit tag. It does not support digest-only references, validate registry reachability, pull images, or enforce every OCI image-reference edge case.
 * - Uses regex pattern `~\b(?:[a-z0-9.-]+(?::\d{2,5})?/)?[a-z0-9._-]+(?:/[a-z0-9._-]+)+:[A-Za-z0-9._-]+\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class KubernetesContainerImageProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b(?:[a-z0-9.-]+(?::\\d{2,5})?/)?[a-z0-9._-]+(?:/[a-z0-9._-]+)+:[A-Za-z0-9._-]+\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KUBERNETES_CONTAINER_IMAGE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KUBERNETES_CONTAINER_IMAGE;
    }
}
