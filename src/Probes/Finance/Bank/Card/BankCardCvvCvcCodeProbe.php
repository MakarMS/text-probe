<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;

class BankCardCvvCvcCodeProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator);
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{3,4}\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_CARD_CVV_CVC_CODE;
    }
}
