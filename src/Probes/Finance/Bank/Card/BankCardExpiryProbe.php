<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;

/**
 * Probe that extracts bank card expiration dates from text.
 *
 * This probe supports common formats such as "MM/YY", "MM/YYYY", "MM-YY",
 * "MM-YYYY" and variants with optional leading zero for the month, using
 * "/", "-", "." or space as a separator.
 */
class BankCardExpiryProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to apply additional
     *                                   checks or normalisation to detected
     *                                   expiration dates
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator);
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(0?[1-9]|1[0-2])[\/\-. ]?(?:\d{2}|\d{4})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_CARD_EXPIRY_DATE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_CARD_EXPIRY_DATE;
    }
}
