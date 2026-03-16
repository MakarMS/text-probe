<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Stripe secret API keys.
 *
 * Matches Stripe secret keys with sk_live_ or sk_test_ prefixes and a base62
 * tail of at least 16 characters.
 */
class StripeSecretKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bsk_(?:live|test)_[A-Za-z0-9]{16,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_SECRET_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_SECRET_KEY;
    }
}
