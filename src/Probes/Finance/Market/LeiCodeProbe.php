<?php

namespace TextProbe\Probes\Finance\Market;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Market\LeiChecksumValidator;
use Override;

/**
 * Probe that extracts Lei Code values from text.
 *
 * Examples:
 * - valid: `5493001KJTIIGC8Y1R35`
 * - invalid: `5493001KJTIIGC8Y1R36`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Z0-9]{18}\d{2}\b/`.
 * - Applies additional validation via `LeiChecksumValidator` (checksum/standard rule).
 */
class LeiCodeProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new LeiChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z0-9]{18}\d{2}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::LEI_CODE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LEI_CODE;
    }
}
