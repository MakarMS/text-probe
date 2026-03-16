<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\EsVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for EsNifIvaProbe.
 */
class EsNifIvaProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new EsVatChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bES[A-Z0-9]\d{7}[A-Z0-9]\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_ES_NIF_IVA
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_ES_NIF_IVA;
    }
}
