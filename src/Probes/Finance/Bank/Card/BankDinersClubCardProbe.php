<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\BankCardNumberValidator;
use TextProbe\Validator\Contracts\IValidator;

class BankDinersClubCardProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(?:(?:30[0-5]|309)(?:[ -]?\d){11}|(?:36|38|39)(?:[ -]?\d){12})(?!\d)/', $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_DINERS_CLUB_CARD_NUMBER;
    }
}
