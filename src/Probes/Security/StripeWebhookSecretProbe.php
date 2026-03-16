<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Stripe Webhook Secret values from text.
 *
 * Examples:
 * - valid: `whsec_1234567890abcdefABCDEF12`
 * - invalid: `whsec_short`
 *
 * Constraints:
 * - Uses regex pattern `/\bwhsec_[A-Za-z0-9]{16,}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class StripeWebhookSecretProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bwhsec_[A-Za-z0-9]{16,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_WEBHOOK_SECRET
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_WEBHOOK_SECRET;
    }
}
