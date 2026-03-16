<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Maven Coordinate values from text.
 *
 * Examples:
 * - valid: `org.slf4j:slf4j-api:2.0.7`
 * - invalid: `org.slf4j:slf4j-api`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class MavenCoordinateProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MAVEN_COORDINATE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MAVEN_COORDINATE;
    }
}
