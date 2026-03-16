<?php

namespace TextProbe\Probes\Contact;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Email Header Message Id values from text.
 *
 * Examples:
 * - valid: `Message-ID: <abc123@example.com>`
 * - invalid: `Message-ID abc123@example.com`
 *
 * Constraints:
 * - Uses regex pattern `/Message-ID:\s*<[^>]+>/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class EmailHeaderMessageIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/Message-ID:\s*<[^>]+>/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::EMAIL_HEADER_MESSAGE_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EMAIL_HEADER_MESSAGE_ID;
    }
}
