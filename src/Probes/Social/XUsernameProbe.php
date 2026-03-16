<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts X Username values from text.
 *
 * Examples:
 * - valid: `@jack`
 * - invalid: `invalid@user@domain`
 *
 * Constraints:
 * - Uses regex pattern `/(?<!\w)@[A-Za-z0-9_]{1,15}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class XUsernameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\w)@[A-Za-z0-9_]{1,15}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::X_USERNAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::X_USERNAME;
    }
}
