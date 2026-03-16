<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Go Module Path values from text.
 *
 * Examples:
 * - valid: `github.com/user/project`
 * - invalid: `github user project`
 *
 * Constraints:
 * - Uses regex pattern `~\b[a-z0-9.-]+\.[a-z]{2,}(?:/[A-Za-z0-9_.-]+)+\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class GoModulePathProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('~\b[a-z0-9.-]+\.[a-z]{2,}(?:/[A-Za-z0-9_.-]+)+\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GO_MODULE_PATH
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GO_MODULE_PATH;
    }
}
