<?php

namespace TextProbe\Probes\Finance\Crypto;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Lightning Invoice values from text.
 *
 * Examples:
 * - valid: `lnbc2500u1p0testinvoicevaluexyzxyzxyz`
 * - invalid: `lnbc123`
 *
 * Constraints:
 * - Uses regex pattern `/\bln(?:bc|tb|bcrt)[0-9a-z]{20,}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class LightningInvoiceProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bln(?:bc|tb|bcrt)[0-9a-z]{20,}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LIGHTNING_INVOICE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LIGHTNING_INVOICE;
    }
}
