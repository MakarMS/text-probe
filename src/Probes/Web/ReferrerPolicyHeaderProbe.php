<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Referrer-Policy headers.
 *
 * Examples:
 * - valid: `Referrer-Policy: no-referrer`
 * - valid: `Referrer-Policy: strict-origin-when-cross-origin`
 *
 * Constraints:
 * - Accepts only the standard policy tokens encoded in the probe. It does not parse comma-separated fallback lists, evaluate browser behavior, or inspect HTML meta equivalents.
 * - Uses regex pattern `/(?mi)^Referrer-Policy:\h*(?:no-referrer|no-referrer-when-downgrade|origin|origin-when-cross-origin|same-origin|strict-origin|strict-origin-when-cross-origin|unsafe-url)$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class ReferrerPolicyHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^Referrer-Policy:\\h*(?:no-referrer|no-referrer-when-downgrade|origin|origin-when-cross-origin|same-origin|strict-origin|strict-origin-when-cross-origin|unsafe-url)$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::REFERRER_POLICY_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::REFERRER_POLICY_HEADER;
    }
}
