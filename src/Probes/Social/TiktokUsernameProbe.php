<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Tiktok Username values from text.
 *
 * Examples:
 * - valid: `@tiktok.creator`
 * - invalid: `@a`
 *
 * Constraints:
 * - Uses regex pattern `/(?<!\w)@[A-Za-z0-9._]{2,24}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TiktokUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\w)@[A-Za-z0-9._]{2,24}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TIKTOK_USERNAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TIKTOK_USERNAME;
    }
}
