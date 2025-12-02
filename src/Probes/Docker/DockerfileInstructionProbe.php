<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Dockerfile instructions from arbitrary text.
 *
 * This probe detects all core Dockerfile instructions in a case-insensitive way,
 * including both single-line and multiline (backslash-continued) forms.
 *
 * Supported instructions:
 *   FROM, RUN, CMD, ENTRYPOINT, COPY, ADD, WORKDIR, ENV, EXPOSE,
 *   VOLUME, USER, LABEL, ARG, STOPSIGNAL, HEALTHCHECK, SHELL.
 */
class DockerfileInstructionProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?:^|[\r\n])\s*\K'
            . '(?:FROM|RUN|CMD|ENTRYPOINT|COPY|ADD|WORKDIR|ENV|EXPOSE|VOLUME|USER|LABEL|ARG|STOPSIGNAL|HEALTHCHECK|SHELL)'
            . '\b[^\n]*'
            . '(?:\\\\\s*[\r\n][^\n]*)*/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DOCKERFILE_INSTRUCTION
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKERFILE_INSTRUCTION;
    }
}
