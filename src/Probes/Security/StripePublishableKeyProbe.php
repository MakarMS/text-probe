<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Stripe publishable API keys.
 *
 * Matches Stripe publishable keys with pk_live_ or pk_test_ prefixes and a
 * base62 tail of at least 16 characters.
 */
class StripePublishableKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bpk_(?:live|test)_[A-Za-z0-9]{16,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_PUBLISHABLE_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_PUBLISHABLE_KEY;
    }
}
