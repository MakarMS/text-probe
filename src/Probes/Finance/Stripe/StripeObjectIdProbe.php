<?php

namespace TextProbe\Probes\Finance\Stripe;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Stripe Object IDs.
 */
class StripeObjectIdProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:pi|ch|cus|in|sub|pm|evt)_[A-Za-z0-9]{6,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::STRIPE_OBJECT_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::STRIPE_OBJECT_ID;
    }
}
