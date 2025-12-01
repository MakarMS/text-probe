<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

/**
 * Probe that extracts Discover card numbers from text.
 *
 * This probe matches Discover-specific ranges (6011, 65, 644–649,
 * 622126–622925) with appropriate lengths, allowing optional spaces
 * or dashes between digit groups, and by default validates candidates
 * using {@see BankCardNumberValidator} (Luhn).
 */
class BankDiscoverCardProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected Discover
     *                                   card numbers. If not provided,
     *                                   {@see BankCardNumberValidator} is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        $pattern = '(?<!\d)'
            . '(?:'
            . '6011(?:[ -]?\d){12}'
            . '|65(?:[ -]?\d){14}'
            . '|64[4-9](?:[ -]?\d){13}'
            . '|622(?:12[6-9]|1[3-9]\d|[2-8]\d{2}|9[0-1]\d|92[0-5])(?:[ -]?\d){10}'
            . ')'
            . '(?!\d)';

        return $this->findByRegex("/$pattern/", $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_DISCOVER_CARD_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_DISCOVER_CARD_NUMBER;
    }
}
