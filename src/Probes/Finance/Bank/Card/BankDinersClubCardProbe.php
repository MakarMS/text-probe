<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Diners Club card numbers from text.
 *
 * This probe matches classic Diners Club prefixes (30[0-5], 309, 36, 38, 39)
 * with total lengths of 13–14 digits, allowing optional spaces or dashes
 * between digit groups, and by default validates candidates using
 * {@see BankCardNumberValidator} (Luhn).
 */
class BankDinersClubCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Diners Club
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
            '/(?<!\d)(?:(?:30[0-5]|309)(?:[ -]?\d){11}|(?:36|38|39)(?:[ -]?\d){12})(?!\d)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::BANK_DINERS_CLUB_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_DINERS_CLUB_CARD_NUMBER;
    }
}
