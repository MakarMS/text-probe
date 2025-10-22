<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;

class BankBicCodeProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator);
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?\b/i', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_BIC_CODE;
    }
}
