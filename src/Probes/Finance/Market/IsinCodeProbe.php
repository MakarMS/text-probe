<?php

namespace TextProbe\Probes\Finance\Market;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Market\IsinChecksumValidator;

/**
 * Probe that extracts Isin Code values from text.
 *
 * Examples:
 * - valid: `US0378331005`
 * - invalid: `US0378331006`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Z]{2}[A-Z0-9]{9}\d\b/`.
 * - Applies additional validation via `IsinChecksumValidator` (checksum/standard rule).
 */
class IsinCodeProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new IsinChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z]{2}[A-Z0-9]{9}\d\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ISIN_CODE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ISIN_CODE;
    }
}
