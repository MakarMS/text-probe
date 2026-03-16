<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Vat\ChUidChecksumValidator;
use Override;

/**
 * Probe that extracts VAT numbers for ChUidMwstProbe.
 */
class ChUidMwstProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override VAT
     *                                   checksum verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new ChUidChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bCHE\d{9}(?:MWST|TVA|IVA)\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::VAT_CH_UID_MWST
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_CH_UID_MWST;
    }
}
