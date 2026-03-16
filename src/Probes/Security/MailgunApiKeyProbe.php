<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Mailgun Api Key values from text.
 *
 * Examples:
 * - valid: `key-1234567890abcdef1234567890abcdef`
 * - invalid: `key-123`
 *
 * Constraints:
 * - Uses regex pattern `/\bkey-[0-9a-f]{32}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class MailgunApiKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bkey-[0-9a-f]{32}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MAILGUN_API_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MAILGUN_API_KEY;
    }
}
