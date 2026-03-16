<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\GrAfmChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for GrAfmVatProbe.
 */
class GrAfmVatProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new GrAfmChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bEL\d{9}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_GR_AFM
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_GR_AFM;
    }
}
