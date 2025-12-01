<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Account\BankIbanNumberValidator;

/**
 * Probe that extracts IBAN (International Bank Account Number) values from text.
 *
 * This probe matches IBANs with or without spaces and, by default, validates
 * candidates using the Mod-97 checksum via {@see BankIbanNumberValidator}.
 */
class BankIbanNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected IBAN numbers.
     *                                   If not provided, {@see BankIbanNumberValidator}
     *                                   is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankIbanNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{2}\d{2}(?: ?[A-Z0-9]){10,30}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_IBAN_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_IBAN_NUMBER;
    }
}
