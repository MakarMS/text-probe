<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\SkVatChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for SkDicVatProbe.
 */
class SkDicVatProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new SkVatChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bSK\d{10}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_SK_DIC
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_SK_DIC;
    }
}
