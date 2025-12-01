<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts MIR card numbers from text.
 *
 * This probe matches MIR-specific prefixes (2200–2204) with a total length
 * of 16 digits, allowing optional spaces or dashes between digit groups,
 * and by default validates candidates using {@see BankCardNumberValidator}
 * (Luhn).
 */
class BankMirCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected MIR card
     *                                   numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)220[0-4](?:[ -]?\d){12}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_MIR_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_MIR_CARD_NUMBER;
    }
}
