<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\BankCardNumberValidator;
use TextProbe\Validator\Contracts\IValidator;

class BankRupayCardProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)(?:508(?:[ -]?\d){13}|(?:60|65|81|82)(?:[ -]?\d){14})(?!\d)/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_RUPAY_CARD_NUMBER;
    }
}