<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\ItVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for ItPartitaIvaProbe.
 */
class ItPartitaIvaProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new ItVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bIT\d{11}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_IT_PARTITA_IVA
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_IT_PARTITA_IVA;
    }
}
