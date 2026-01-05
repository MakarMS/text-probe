<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\BeVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for BeVatNumberProbe.
 */
class BeVatNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BeVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bBE0?\d{9}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_BE_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_BE_NUMBER;
    }
}
