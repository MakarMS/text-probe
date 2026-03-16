<?php

namespace TextProbe\Probes\Finance\Stripe;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Stripe Invoice IDs.
 */
class StripeInvoiceIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bin_[A-Za-z0-9]{10,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_INVOICE_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_INVOICE_ID;
    }
}
