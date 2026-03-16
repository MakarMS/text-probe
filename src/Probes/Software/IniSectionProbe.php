<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Ini Section values from text.
 *
 * Examples:
 * - valid: `[database]`
 * - invalid: `database`
 *
 * Constraints:
 * - Uses regex pattern `/\[[A-Za-z0-9_.-]+\]/`.
 * - Relies on regex filtering only (no additional validator).
 */
class IniSectionProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\[[A-Za-z0-9_.-]+\]/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::INI_SECTION
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::INI_SECTION;
    }
}
