<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts UnionPay card numbers from text.
 *
 * This probe matches UnionPay-specific ranges starting with "62" and supports
 * total card number lengths between 16 and 19 digits, allowing optional spaces
 * or dashes between digit groups. By default, candidates are validated using
 * {@see BankCardNumberValidator} (Luhn).
 */
class BankUnionpayCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected UnionPay card
     *                                   numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)62(?:[ -]?\d){14,17}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_UNIONPAY_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_UNIONPAY_CARD_NUMBER;
    }
}
