<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Bank\Account\BankRoutingValidator;

/**
 * Probe that extracts US bank routing numbers from text.
 *
 * This probe matches 9-digit ABA routing numbers and, by default, validates
 * candidates using {@see BankRoutingValidator}, which implements the official
 * checksum algorithm to reduce false positives.
 */
class BankRoutingNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected routing
     *                                   numbers. If not provided, {@see BankRoutingValidator}
     *                                   is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new BankRoutingValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{9}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_ROUTING_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_ROUTING_NUMBER;
    }
}
