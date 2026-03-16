<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts French numero fiscal reference numbers.
 */
class FrNumeroFiscalReferenceProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{13}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::FR_NUMERO_FISCAL_REFERENCE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FR_NUMERO_FISCAL_REFERENCE;
    }
}
