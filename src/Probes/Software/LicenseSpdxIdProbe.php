<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts License Spdx Id values from text.
 *
 * Examples:
 * - valid: `Apache-2.0`
 * - invalid: `Apache2`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:MIT|Apache-2\.0|BSD-2-Clause|BSD-3-Clause|GPL-3\.0-only|LGPL-3\.0-only|MPL-2\.0)\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class LicenseSpdxIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:MIT|Apache-2\.0|BSD-2-Clause|BSD-3-Clause|GPL-3\.0-only|LGPL-3\.0-only|MPL-2\.0)\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LICENSE_SPDX_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LICENSE_SPDX_ID;
    }
}
