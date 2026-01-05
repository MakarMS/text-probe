<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\NlVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for NlBtwNummerProbe.
 */
class NlBtwNummerProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new NlVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bNL\d{9}B\d{2}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_NL_BTW_NUMMER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_NL_BTW_NUMMER;
    }
}
