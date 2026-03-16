<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Pypi Package Name values from text.
 *
 * Examples:
 * - valid: `requests-toolbelt`
 * - invalid: `requests toolbelt`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z0-9]+(?:[-_.][a-z0-9]+)+\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class PypiPackageNameProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z0-9]+(?:[-_.][a-z0-9]+)+\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PYPI_PACKAGE_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PYPI_PACKAGE_NAME;
    }
}
