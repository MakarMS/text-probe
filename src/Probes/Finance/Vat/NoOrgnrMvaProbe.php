<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\NoOrgnrChecksumValidator;

/**
 * Probe that extracts VAT numbers for NoOrgnrMvaProbe.
 */
class NoOrgnrMvaProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new NoOrgnrChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bNO\d{9}MVA\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_NO_ORGNR_MVA
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_NO_ORGNR_MVA;
    }
}
