<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Gradle Dependency Notation values from text.
 *
 * Examples:
 * - valid: `com.google.guava:guava:33.0.0-jre`
 * - invalid: `com.google.guava:guava`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class GradleDependencyNotationProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+:[a-zA-Z0-9_.-]+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GRADLE_DEPENDENCY_NOTATION
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GRADLE_DEPENDENCY_NOTATION;
    }
}
