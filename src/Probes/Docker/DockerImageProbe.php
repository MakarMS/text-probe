<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

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
            $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_IMAGE;
    }
}
