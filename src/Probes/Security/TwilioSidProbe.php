<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Twilio Sid values from text.
 *
 * Examples:
 * - valid: `AC1234567890abcdef1234567890abcdef`
 * - invalid: `AC1234`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:AC|SM|PN|MG)[0-9a-fA-F]{32}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TwilioSidProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:AC|SM|PN|MG)[0-9a-fA-F]{32}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TWILIO_SID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TWILIO_SID;
    }
}
