<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\FiVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for FiAlvNumeroProbe.
 */
class FiAlvNumeroProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new FiVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bFI\d{8}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_FI_ALV_NUMERO
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_FI_ALV_NUMERO;
    }
}
