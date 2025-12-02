<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Docker CLI flags from text.
 *
 * This probe detects commonly used flags and their arguments in `docker run`
 * and related commands, including:
 *
 *  - short flags with arguments: -p 8080:80, -v src:/app, -e KEY=VALUE
 *  - standalone short flags: -d, -i, -t, -u
 *  - long flags with equals: --env=KEY=VALUE, --name=backend
 *  - long flags with arguments: --cpus 2, --env KEY=VALUE
 *  - standalone long flags: --rm, --tty, --detach
 *
 * It focuses on flag tokens themselves without fully parsing Docker CLI syntax.
 */
class DockerCliFlagProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $arg = '\S+(?<![.,;!?\)\]\}])';

        return $this->findByRegex(
            '/(?:'
            . '-[pve]\s+' . $arg
            . '|'
            . '-[A-Za-z](?![A-Za-z0-9_-])'
            . '|'
            . '--[A-Za-z0-9][A-Za-z0-9_-]*=' . $arg
            . '|'
            . '--[A-Za-z0-9][A-Za-z0-9_-]*\s+' . $arg
            . '|'
            . '--[A-Za-z0-9][A-Za-z0-9_-]*(?![A-Za-z0-9_-])'
            . ')/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_CLI_FLAG
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_CLI_FLAG;
    }
}
