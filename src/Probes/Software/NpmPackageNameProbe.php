<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Npm Package Name values from text.
 *
 * Examples:
 * - valid: `@scope/package-name`
 * - invalid: `Package Name`
 *
 * Constraints:
 * - Uses regex pattern `/(?:@[a-z0-9-~][a-z0-9-._~]*\/[a-z0-9-~][a-z0-9-._~]*|[a-z0-9-~]+(?:[.-][a-z0-9-~]+)+)/`.
 * - Relies on regex filtering only (no additional validator).
 */
class NpmPackageNameProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?:@[a-z0-9-~][a-z0-9-._~]*\/[a-z0-9-~][a-z0-9-._~]*|[a-z0-9-~]+(?:[.-][a-z0-9-~]+)+)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NPM_PACKAGE_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NPM_PACKAGE_NAME;
    }
}
