<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\DkCvrChecksumValidator;

/**
 * Probe that extracts VAT numbers for DkCvrProbe.
 */
class DkCvrProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new DkCvrChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bDK\d{8}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_DK_CVR
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_DK_CVR;
    }
}
