<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\System\W3cSpanIdValidator;

/**
 * Probe that extracts Span Id W3c values from text.
 *
 * Examples:
 * - valid: `00f067aa0ba902b7`
 * - invalid: `0000000000000000`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9a-f]{16}\b/i`.
 * - Applies additional validation via `W3cSpanIdValidator` (checksum/standard rule).
 */
class SpanIdW3cProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new W3cSpanIdValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{16}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SPAN_ID_W3C
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SPAN_ID_W3C;
    }
}
