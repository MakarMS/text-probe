<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\BankCardNumberValidator;
use TextProbe\Validator\Contracts\IValidator;

class BankTroyCardProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)9792(?:[ -]?\d){12}(?!\d)/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_TROY_CARD_NUMBER;
    }
}