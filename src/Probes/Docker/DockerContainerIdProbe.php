<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

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

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_CONTAINER_ID;
    }
}
