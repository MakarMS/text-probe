<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\LvVatChecksumValidator;

/**
 * Probe that extracts VAT numbers for LvPvnRegNrProbe.
 */
class LvPvnRegNrProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new LvVatChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bLV\d{11}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_LV_PVN_REG_NR
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_LV_PVN_REG_NR;
    }
}
