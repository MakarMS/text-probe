<?php

namespace TextProbe\Probes\Finance\Reference;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts numeric invoice identifiers.
 */
class InvoiceNumericIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{6,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::INVOICE_NUMERIC_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::INVOICE_NUMERIC_ID;
    }
}
