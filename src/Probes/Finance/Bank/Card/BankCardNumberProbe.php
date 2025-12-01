<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts generic bank card numbers from text.
 *
 * This probe matches card numbers in continuous, spaced or dashed formats
 * and, by default, validates candidates using {@see BankCardNumberValidator},
 * which implements the Luhn algorithm and scheme-specific constraints.
 */
class BankCardNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected card numbers.
     *                                   If not provided, {@see BankCardNumberValidator}
     *                                   is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)(?:\d[ -]?){12,18}\d(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_CARD_NUMBER;
    }
}
