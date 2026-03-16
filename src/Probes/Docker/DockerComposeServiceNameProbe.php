<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Docker Compose Service Name values from text.
 *
 * Examples:
 * - valid: `web:`
 * - invalid: `Web:`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z][a-z0-9_-]*:/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DockerComposeServiceNameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z][a-z0-9_-]*:/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_COMPOSE_SERVICE_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_COMPOSE_SERVICE_NAME;
    }
}
