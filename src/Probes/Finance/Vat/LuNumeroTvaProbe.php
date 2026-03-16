<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\LuVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for LuNumeroTvaProbe.
 */
class LuNumeroTvaProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new LuVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bLU\d{8}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_LU_NUMERO_TVA
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_LU_NUMERO_TVA;
    }
}
