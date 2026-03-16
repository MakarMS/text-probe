<?php

namespace TextProbe\Probes\Finance\Market;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Market\CusipCheckDigitValidator;

/**
 * Probe that extracts Cusip Code values from text.
 *
 * Examples:
 * - valid: `037833100`
 * - invalid: `037833101`
 *
 * Constraints:
 *
 * - Uses regex pattern `/\b[0-9A-Z*@#]{8}[0-9]\b/`.
 * - Applies additional validation via `CusipCheckDigitValidator` (checksum/standard rule).
 */
class CusipCodeProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new CusipCheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9A-Z*@#]{8}[0-9]\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CUSIP_CODE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CUSIP_CODE;
    }
}
