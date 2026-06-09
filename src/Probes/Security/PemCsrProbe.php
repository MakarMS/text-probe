<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts PEM certificate signing request blocks.
 *
 * Examples:
 * - valid: `-----BEGIN CERTIFICATE REQUEST-----
 *   MIIBexample
 *   -----END CERTIFICATE REQUEST-----`
 * - valid: `-----BEGIN CERTIFICATE REQUEST-----
 *   ABCDEF123456
 *   -----END CERTIFICATE REQUEST-----`
 *
 * Constraints:
 * - Matches the PEM begin/end markers and the enclosed text only; it does not base64-decode the body, parse ASN.1,
 *   validate the CSR signature, or check subject/SAN fields.
 * - Uses regex pattern `/-----BEGIN CERTIFICATE REQUEST-----[\s\S]+?-----END CERTIFICATE REQUEST-----/`.
 * - Relies on regex filtering only (no additional validator).
 */
class PemCsrProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/-----BEGIN CERTIFICATE REQUEST-----[\\s\\S]+?-----END CERTIFICATE REQUEST-----/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PEM_CSR
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PEM_CSR;
    }
}
