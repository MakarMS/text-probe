<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Eu Driving License Category values from text.
 *
 * Examples:
 * - valid: `C1E`
 * - invalid: `ZZ`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:AM|A1|A2|A|B1|B|BE|C1|C1E|C|CE|D1|D1E|D|DE|T)\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class EuDrivingLicenseCategoryProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:AM|A1|A2|A|B1|B|BE|C1|C1E|C|CE|D1|D1E|D|DE|T)\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::EU_DRIVING_LICENSE_CATEGORY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EU_DRIVING_LICENSE_CATEGORY;
    }
}
