<?php

namespace TextProbe\Probes\Finance\Bank\Account;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Iban Masked values from text.
 *
 * Examples:
 * - valid: `DE89 **** **** **** 0130 00`
 * - invalid: `DE89`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Z]{2}\d{2}[A-Z0-9* ]{10,30}\d{2,4}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class IbanMaskedProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{2}\d{2}[A-Z0-9* ]{10,30}\d{2,4}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IBAN_MASKED
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IBAN_MASKED;
    }
}
