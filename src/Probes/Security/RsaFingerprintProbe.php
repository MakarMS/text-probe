<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts OpenSSH-style RSA SHA-256 fingerprints.
 *
 * Examples:
 * - valid: `SHA256:abcdefghijklmnopqrstuvwxyz1234567890`
 * - valid: `SHA256:ABCDEFGHIJKLMNOPQRSTUVWXYZ_1234567890=`
 *
 * Constraints:
 * - Requires the `SHA256:` prefix and at least 20 base64/base64url-like characters. It does not decode the fingerprint, verify that it belongs to an RSA key, or parse full `ssh-keygen -l` output fields.
 * - Uses regex pattern `/\bSHA256:[A-Za-z0-9+\/_-]{20,}={0,2}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class RsaFingerprintProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\bSHA256:[A-Za-z0-9+\\/_-]{20,}={0,2}\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RSA_FINGERPRINT
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RSA_FINGERPRINT;
    }
}
