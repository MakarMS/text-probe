<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Troy card numbers from text.
 *
 * This probe matches Troy-specific prefixes (9792) with a total length of
 * 16 digits, allowing optional spaces or dashes between digit groups, and
 * by default validates candidates using {@see BankCardNumberValidator} (Luhn).
 */
class BankTroyCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Troy card
     *                                   numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)9792(?:[ -]?\d){12}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_TROY_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_TROY_CARD_NUMBER;
    }
}
