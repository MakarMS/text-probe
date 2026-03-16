<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\RoVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for RoCuiVatProbe.
 */
class RoCuiVatProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new RoVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bRO\d{2,10}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_RO_CUI
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_RO_CUI;
    }
}
