<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\SeVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for SeVatNummerProbe.
 */
class SeVatNummerProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new SeVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bSE\d{10}01\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_SE_NUMMER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_SE_NUMMER;
    }
}
