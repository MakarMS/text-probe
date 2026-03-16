<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Semver Pre Release values from text.
 *
 * Examples:
 * - valid: `1.2.3-rc.1`
 * - invalid: `1.2.3`
 *
 * Constraints:
 * - Uses regex pattern `/\bv?\d+\.\d+\.\d+-[0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class SemverPreReleaseProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bv?\d+\.\d+\.\d+-[0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SEMVER_PRE_RELEASE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SEMVER_PRE_RELEASE;
    }
}
