<?php

namespace TextProbe\Probes\Text;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Text\Isbn13ChecksumValidator;

/**
 * Probe that extracts Isbn13 values from text.
 *
 * Examples:
 * - valid: `978-0-306-40615-7`
 * - invalid: `978-0-306-40615-8`
 *
 * Constraints:
 * - Uses regex pattern `/\b97[89][-\d ]{10,16}\b/`.
 * - Applies additional validation via `Isbn13ChecksumValidator` (checksum/standard rule).
 */
class Isbn13Probe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new Isbn13ChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b97[89][-\d ]{10,16}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ISBN_13
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ISBN_13;
    }
}
