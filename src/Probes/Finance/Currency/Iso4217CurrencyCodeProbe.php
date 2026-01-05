<?php

namespace TextProbe\Probes\Finance\Currency;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Currency\ISO4217WhitelistValidator;

/**
 * Probe that extracts ISO-4217 currency codes.
 */
class Iso4217CurrencyCodeProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override ISO-4217
     *                                   code validation
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new ISO4217WhitelistValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{3}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ISO4217_CURRENCY_CODE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ISO4217_CURRENCY_CODE;
    }
}
