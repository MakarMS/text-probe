<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Docker container IDs from text.
 *
 * This probe detects lowercase hexadecimal identifiers in both short (12 chars)
 * and full (64 chars) formats commonly seen in `docker ps`, logs, CI output and
 * orchestration traces, while ignoring values with invalid lengths or non-hex
 * characters.
 */
class DockerContainerIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b('
            . '[a-f0-9]{12}|[a-f0-9]{64}'
            . ')\b/x',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_CONTAINER_ID
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_CONTAINER_ID;
    }
}
