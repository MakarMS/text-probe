<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\IeVatChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for IeVatNumberProbe.
 */
class IeVatNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new IeVatChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bIE(?:\d{7}[A-Z]{1,2}|\d[A-Z]\d{5}[A-Z])\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_IE_NUMBER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_IE_NUMBER;
    }
}
