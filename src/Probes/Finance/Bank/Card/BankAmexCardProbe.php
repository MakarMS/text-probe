<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

class BankAmexCardProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)3[47](?:[ -]?\d){13}(?!\d)/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_AMEX_CARD_NUMBER;
    }
}
