<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Maestro card numbers from text.
 *
 * This probe matches typical Maestro prefixes (5018, 5020, 5038, 5612, 5893,
 * 6304, 6759, 6761–6763) with total lengths between 12 and 19 digits, allowing
 * optional spaces or dashes between digit groups, and by default validates
 * candidates using {@see BankCardNumberValidator} (Luhn).
 */
class BankMaestroCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Maestro card
     *                                   numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(?:5018|5020|5038|5612|5893|6304|6759|6761|6762|6763)(?:[ -]?\d){8,15}(?!\d)/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::BANK_MAESTRO_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_MAESTRO_CARD_NUMBER;
    }
}
