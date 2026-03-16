<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Twilio Auth Token values from text.
 *
 * Examples:
 * - valid: `abcdefabcdefabcdefabcdefabcdefab`
 * - invalid: `abcdef`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9a-fA-F]{32}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TwilioAuthTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-fA-F]{32}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TWILIO_AUTH_TOKEN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TWILIO_AUTH_TOKEN;
    }
}
