<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Docker labels from text.
 *
 * This probe detects key/value label pairs in the form `key=value` and
 * `key="value"` typically found in Dockerfiles and CLI commands, for example:
 *
 *  - LABEL version="1.0.0"
 *  - LABEL description="My service" vendor=acme
 *
 * It focuses on the `key=value` fragments themselves, without attempting to
 * fully parse Dockerfile syntax or validate label semantics.
 */
class DockerLabelProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/\b[A-Za-z0-9._-]+\s*=\s*(?:"[^"]*"|\S+)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_LABEL
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_LABEL;
    }
}
