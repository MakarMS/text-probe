<?php

namespace TextProbe\Probes\Barcode;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Barcode\Gtin14ChecksumValidator;
use TextProbe\Validator\Contracts\IValidator;
use Override;

/**
 * Probe that extracts Gs1 Gtin14 values from text.
 *
 * Examples:
 * - valid: `10012345678902`
 * - invalid: `10012345678903`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{14}\b/`.
 * - Applies additional validation via `Gtin14ChecksumValidator` (checksum/standard rule).
 */
class Gs1Gtin14Probe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new Gtin14ChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{14}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GS1_GTIN_14
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GS1_GTIN_14;
    }
}
