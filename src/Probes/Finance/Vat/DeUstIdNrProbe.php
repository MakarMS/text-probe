<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\DeUstIdNrChecksumValidator;

/**
 * Probe that extracts VAT numbers for DeUstIdNrProbe.
 */
class DeUstIdNrProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new DeUstIdNrChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bDE\d{9}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_DE_UST_ID_NR
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_DE_UST_ID_NR;
    }
}
