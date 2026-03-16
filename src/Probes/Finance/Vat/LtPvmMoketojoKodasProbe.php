<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\LtVatChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for LtPvmMoketojoKodasProbe.
 */
class LtPvmMoketojoKodasProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new LtVatChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bLT(?:\d{9}|\d{12})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_LT_PVM_MOKETOJO_KODAS
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_LT_PVM_MOKETOJO_KODAS;
    }
}
