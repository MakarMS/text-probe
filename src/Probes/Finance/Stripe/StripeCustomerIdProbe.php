<?php

namespace TextProbe\Probes\Finance\Stripe;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Stripe Customer IDs.
 */
class StripeCustomerIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bcus_[A-Za-z0-9]{6,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_CUSTOMER_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_CUSTOMER_ID;
    }
}
