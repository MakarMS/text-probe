<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Account\BankIbanNumberValidator;

class BankIbanNumberProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankIbanNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{2}\d{2}(?: ?[A-Z0-9]){10,30}\b/i', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_IBAN_NUMBER;
    }
}