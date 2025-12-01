<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Verve card numbers from text.
 *
 * This probe matches Verve-specific prefixes (5060, 5061, 6500–6509) with total
 * lengths between 13 and 19 digits, allowing optional spaces or dashes between
 * digit groups, and by default validates candidates using
 * {@see BankCardNumberValidator} (Luhn).
 */
class BankVerveCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Verve card
     *                                   numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)(?:5060|5061|650[0-9])(?:[ -]?\d){12,15}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_VERVE_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_VERVE_CARD_NUMBER;
    }
}
