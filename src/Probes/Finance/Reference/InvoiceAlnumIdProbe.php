<?php

namespace TextProbe\Probes\Finance\Reference;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts alphanumeric invoice identifiers.
 */
class InvoiceAlnumIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z0-9][A-Z0-9\-\/]{5,31}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::INVOICE_ALNUM_ID
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::INVOICE_ALNUM_ID;
    }
}
