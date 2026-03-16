<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\FrVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for FrNumeroTvaIntracommunautaireProbe.
 */
class FrNumeroTvaIntracommunautaireProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new FrVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bFR[A-Z0-9]{2}\d{9}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_FR_NUMERO_TVA_INTRACOMMUNAUTAIRE;
    }
}
