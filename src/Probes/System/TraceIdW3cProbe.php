<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\System\W3cTraceIdValidator;

/**
 * Probe that extracts Trace Id W3c values from text.
 *
 * Examples:
 * - valid: `4bf92f3577b34da6a3ce929d0e0e4736`
 * - invalid: `00000000000000000000000000000000`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9a-f]{32}\b/i`.
 * - Applies additional validation via `W3cTraceIdValidator` (checksum/standard rule).
 */
class TraceIdW3cProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new W3cTraceIdValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{32}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TRACE_ID_W3C
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TRACE_ID_W3C;
    }
}
