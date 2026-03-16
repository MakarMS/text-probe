<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Composer Package Name values from text.
 *
 * Examples:
 * - valid: `symfony/console`
 * - invalid: `symfony console`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z0-9_.-]+\/[a-z0-9_.-]+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class ComposerPackageNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z0-9_.-]+\/[a-z0-9_.-]+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::COMPOSER_PACKAGE_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::COMPOSER_PACKAGE_NAME;
    }
}
