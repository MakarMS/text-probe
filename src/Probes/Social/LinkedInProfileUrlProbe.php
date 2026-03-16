<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Linked In Profile Url values from text.
 *
 * Examples:
 * - valid: `https://linkedin.com/in/john-doe`
 * - invalid: `linkedin profile`
 *
 * Constraints:
 * - Uses regex pattern `~https?://(?:[a-z]{2,3}\.)?linkedin\.com/in/[A-Za-z0-9_%.-]+/?~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class LinkedInProfileUrlProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://(?:[a-z]{2,3}\.)?linkedin\.com/in/[A-Za-z0-9_%.-]+/?~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LINKEDIN_PROFILE_URL
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LINKEDIN_PROFILE_URL;
    }
}
