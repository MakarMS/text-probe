<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\BankCardNumberValidator;
use TextProbe\Validator\Contracts\IValidator;

class BankDiscoverCardProbe extends Probe implements IProbe
{
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


    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_DISCOVER_CARD_NUMBER;
    }
}