<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\SiVatChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for SiDavcnaStevilkaVatProbe.
 */
class SiDavcnaStevilkaVatProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new SiVatChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bSI\d{8}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_SI_DAVCNA_STEVILKA
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_SI_DAVCNA_STEVILKA;
    }
}
