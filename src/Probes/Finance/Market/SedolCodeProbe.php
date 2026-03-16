<?php

namespace TextProbe\Probes\Finance\Market;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Market\SedolCheckDigitValidator;

/**
 * Probe that extracts Sedol Code values from text.
 *
 * Examples:
 * - valid: `0263494`
 * - invalid: `0263495`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9BCDFGHJKLMNPQRSTVWXYZ]{6}[0-9]\b/`.
 * - Applies additional validation via `SedolCheckDigitValidator` (checksum/standard rule).
 */
class SedolCodeProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new SedolCheckDigitValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9BCDFGHJKLMNPQRSTVWXYZ]{6}[0-9]\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SEDOL_CODE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SEDOL_CODE;
    }
}
