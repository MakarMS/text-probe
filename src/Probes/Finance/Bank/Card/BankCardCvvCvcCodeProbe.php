<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;

/**
 * Probe that extracts card security codes (CVV/CVC) from text.
 *
 * This probe matches 3–4 digit numeric codes that typically represent
 * card security codes, while allowing an optional validator to further
 * restrict or post-process detected values in a specific context.
 */
class BankCardCvvCvcCodeProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to apply additional
     *                                   checks to detected CVV/CVC codes
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator);
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{3,4}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_CARD_CVV_CVC_CODE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_CARD_CVV_CVC_CODE;
    }
}
