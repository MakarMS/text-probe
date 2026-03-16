<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Nuget Package Id values from text.
 *
 * Examples:
 * - valid: `Newtonsoft.Json`
 * - invalid: `1Json`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Za-z][A-Za-z0-9]*(?:\.[A-Za-z0-9][A-Za-z0-9]*)+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class NugetPackageIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Za-z][A-Za-z0-9]*(?:\.[A-Za-z0-9][A-Za-z0-9]*)+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NUGET_PACKAGE_ID
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NUGET_PACKAGE_ID;
    }
}
