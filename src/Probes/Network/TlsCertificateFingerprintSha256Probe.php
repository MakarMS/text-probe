<?php

namespace TextProbe\Probes\Network;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts SHA-256 TLS certificate fingerprints.
 *
 * Examples:
 * - valid: `SHA256 Fingerprint=AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99`
 * - valid: `SHA256 Fingerprint=00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF:00:11:22:33:44:55:66:77:88:99:AA:BB:CC:DD:EE:FF`
 *
 * Constraints:
 * - Requires the literal `SHA256 Fingerprint=` prefix followed by 32 colon-separated hex bytes. It does not connect to TLS endpoints, parse certificates, or compare fingerprints against a trust store.
 * - Uses regex pattern `/\bSHA256 Fingerprint=(?:[A-Fa-f0-9]{2}:){31}[A-Fa-f0-9]{2}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TlsCertificateFingerprintSha256Probe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\bSHA256 Fingerprint=(?:[A-Fa-f0-9]{2}:){31}[A-Fa-f0-9]{2}\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TLS_CERTIFICATE_FINGERPRINT_SHA256;
    }
}
