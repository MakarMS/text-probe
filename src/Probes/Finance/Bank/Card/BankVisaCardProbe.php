<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Visa card numbers from text.
 *
 * This probe matches Visa-specific prefixes starting with "4" and supports
 * total card number lengths between 13 and 19 digits, allowing optional
 * spaces or dashes between digit groups. By default, candidates are validated
 * using {@see BankCardNumberValidator} (Luhn).
 */
class BankVisaCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Visa card
     *                                   numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)4(?:[ -]?\d){12,18}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_VISA_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_VISA_CARD_NUMBER;
    }
}
