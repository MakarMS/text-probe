<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Docker image names with tags from text.
 *
 * This probe supports registries, multi-level namespaces and semantic or custom
 * tags (e.g. "nginx:1.25.1", "redis:latest", "ghcr.io/app/api:v2"), while
 * ignoring image names without tags.
 */
class DockerImageProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b('
            . '[a-z0-9]+(?:[._-][a-z0-9]+)*'
            . '(?:\/[a-z0-9]+(?:[._-][a-z0-9]+)*)*'
            . ':'
            . '(?:latest|[A-Za-z0-9._-]+)'
            . ')\b/x',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_IMAGE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_IMAGE;
    }
}
