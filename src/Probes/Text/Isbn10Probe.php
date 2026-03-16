<?php

namespace TextProbe\Probes\Text;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Text\Isbn10ChecksumValidator;

/**
 * Probe that extracts Isbn10 values from text.
 *
 * Examples:
 * - valid: `0-306-40615-2`
 * - invalid: `0-306-40615-3`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:\d[- ]?){9}[\dX]\b/i`.
 * - Applies additional validation via `Isbn10ChecksumValidator` (checksum/standard rule).
 */
class Isbn10Probe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new Isbn10ChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:\d[- ]?){9}[\dX]\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ISBN_10
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ISBN_10;
    }
}
