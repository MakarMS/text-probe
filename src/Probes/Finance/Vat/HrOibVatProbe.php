<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\HrOibChecksumValidator;

/**
 * Probe that extracts VAT numbers for HrOibVatProbe.
 */
class HrOibVatProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new HrOibChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bHR\d{11}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_HR_OIB
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_HR_OIB;
    }
}
