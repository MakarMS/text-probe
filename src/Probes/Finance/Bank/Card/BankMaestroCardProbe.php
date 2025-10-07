<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Card\BankCardNumberValidator;

class BankMaestroCardProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankCardNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(?:5018|5020|5038|5612|5893|6304|6759|6761|6762|6763)(?:[ -]?\d){8,15}(?!\d)/', $text
        );
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_MAESTRO_CARD_NUMBER;
    }
}