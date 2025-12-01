<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;

/**
 * Probe that extracts SWIFT/BIC bank identifier codes from text.
 *
 * This probe matches 8–11 character BIC codes (e.g. "DEUTDEFF500"), following
 * the standard structure for institution, country, location and optional branch
 * codes, while allowing an optional validator to further filter candidates.
 */
class BankBicCodeProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to apply additional
     *                                   checks to detected BIC codes
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator);
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BANK_BIC_CODE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BANK_BIC_CODE;
    }
}
