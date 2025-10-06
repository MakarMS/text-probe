<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\BankCardNumberValidator;
use TextProbe\Validator\Contracts\IValidator;

class BankVerveCardProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)(?:5060|5061|650[0-9])(?:[ -]?\d){12,15}(?!\d)/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_VERVE_CARD_NUMBER;
    }
}