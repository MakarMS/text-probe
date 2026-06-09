<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts SHA-256 fingerprints in plain hex or colon-separated form.
 *
 * Examples:
 * - valid: `0123456789abcdef0123456789abcdef0123456789abcdef0123456789abcdef`
 * - valid: `AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99`
 *
 * Constraints:
 * - Accepts exactly 64 hexadecimal characters or 32 colon-separated hex bytes. It does not hash source data, compare the fingerprint to a certificate or key, or distinguish SHA-256 fingerprints from any other 64-hex identifier.
 * - Uses regex pattern `/\b(?:[A-Fa-f0-9]{64}|(?:[A-Fa-f0-9]{2}:){31}[A-Fa-f0-9]{2})\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class Sha256FingerprintProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?:[A-Fa-f0-9]{64}|(?:[A-Fa-f0-9]{2}:){31}[A-Fa-f0-9]{2})\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SHA256_FINGERPRINT
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SHA256_FINGERPRINT;
    }
}
