<?php

namespace TextProbe\Probes\Identity;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Identity\ImeiLuhnValidator;
use Override;

/**
 * Probe that extracts Imei values from text.
 *
 * Examples:
 * - valid: `490154203237518`
 * - invalid: `490154203237519`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{15}\b/`.
 * - Applies additional validation via `ImeiLuhnValidator` (checksum/standard rule).
 */
class ImeiProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new ImeiLuhnValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{15}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IMEI
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IMEI;
    }
}
