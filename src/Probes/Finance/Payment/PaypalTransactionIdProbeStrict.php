<?php

namespace TextProbe\Probes\Finance\Payment;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts strict PayPal transaction identifiers.
 */
class PaypalTransactionIdProbeStrict extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z0-9]{17}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PAYPAL_TRANSACTION_ID_STRICT
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PAYPAL_TRANSACTION_ID_STRICT;
    }
}
