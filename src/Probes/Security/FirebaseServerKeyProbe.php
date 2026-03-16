<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Firebase Server Key values from text.
 *
 * Examples:
 * - valid: `AAAA1234_ab:abcdefghijklmnopqrstuvwxyzABCDEF0123456789`
 * - invalid: `AAAA:key`
 *
 * Constraints:
 * - Uses regex pattern `/\bAAAA[A-Za-z0-9_-]{7}:[A-Za-z0-9_-]{20,}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class FirebaseServerKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bAAAA[A-Za-z0-9_-]{7}:[A-Za-z0-9_-]{20,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FIREBASE_SERVER_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FIREBASE_SERVER_KEY;
    }
}
