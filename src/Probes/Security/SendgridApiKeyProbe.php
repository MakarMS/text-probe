<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Sendgrid Api Key values from text.
 *
 * Examples:
 * - valid: `SG.aaaaaaaaaaaaaaaaaaaa.bbbbbbbbbbbbbbbbbbbb`
 * - invalid: `SG.short.short`
 *
 * Constraints:
 * - Uses regex pattern `/\bSG\.[A-Za-z0-9_-]{20,}\.[A-Za-z0-9_-]{20,}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class SendgridApiKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bSG\.[A-Za-z0-9_-]{20,}\.[A-Za-z0-9_-]{20,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SENDGRID_API_KEY
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SENDGRID_API_KEY;
    }
}
