<?php

namespace TextProbe\Probes\Docker;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Docker Network Name values from text.
 *
 * Examples:
 * - valid: `backend-net`
 * - invalid: `net`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z0-9]+(?:[_.-][a-zA-Z0-9]+)+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DockerNetworkNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z0-9]+(?:[_.-][a-zA-Z0-9]+)+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DOCKER_NETWORK_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DOCKER_NETWORK_NAME;
    }
}
