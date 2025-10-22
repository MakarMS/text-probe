<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Account\BankRoutingValidator;

class BankRoutingNumberProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankRoutingValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{9}\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_ROUTING_NUMBER;
    }
}
