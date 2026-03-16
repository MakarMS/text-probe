<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\BgVatChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for BgVatNumberProbe.
 */
class BgVatNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BgVatChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bBG\d{9,10}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_BG_NUMBER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_BG_NUMBER;
    }
}
