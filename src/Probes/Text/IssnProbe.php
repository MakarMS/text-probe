<?php

namespace TextProbe\Probes\Text;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Text\IssnChecksumValidator;

/**
 * Probe that extracts Issn values from text.
 *
 * Examples:
 * - valid: `0317-8471`
 * - invalid: `0317-8472`
 *
 * Constraints:
 * - Uses regex pattern `/\b\d{4}-\d{3}[\dX]\b/i`.
 * - Applies additional validation via `IssnChecksumValidator` (checksum/standard rule).
 */
class IssnProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new IssnChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{4}-\d{3}[\dX]\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ISSN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ISSN;
    }
}
