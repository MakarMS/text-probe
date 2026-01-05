<?php

namespace TextProbe\Probes\Finance\Stripe;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Stripe PaymentMethod IDs.
 */
class StripePaymentMethodIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bpm_[A-Za-z0-9]{10,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_PAYMENT_METHOD_ID
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_PAYMENT_METHOD_ID;
    }
}
