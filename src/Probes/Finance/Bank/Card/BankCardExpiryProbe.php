<?php

namespace TextProbe\Probes\Finance\Bank\Card;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;

class BankCardExpiryProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator);
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(0?[1-9]|1[0-2])[\/\-. ]?(?:\d{2}|\d{4})\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_CARD_EXPIRY_DATE;
    }
}
