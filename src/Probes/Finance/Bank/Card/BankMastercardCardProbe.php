<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Mastercard card numbers from text.
 *
 * This probe matches Mastercard-specific prefixes (51–55, 2221–2720) with a
 * total length of 16 digits, allowing optional spaces or dashes between digit
 * groups, and by default validates candidates using {@see BankCardNumberValidator}
 * (Luhn).
 */
class BankMastercardCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Mastercard
     *                                   card numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(?:5[1-5]\d{2}|222[1-9]|22[3-9]\d|2[3-6]\d{2}|27[01]\d|2720)(?:[ -]?\d){12}(?!\d)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::BANK_MASTERCARD_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_MASTERCARD_CARD_NUMBER;
    }
}
