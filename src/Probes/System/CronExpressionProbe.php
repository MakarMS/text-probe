<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Cron Expression values from text.
 *
 * Examples:
 * - valid: `5 0 1 1 *`
 * - invalid: `60 24 32 13 7`
 *
 * Constraints:
 * - Uses regex pattern `/(?:\*|[0-5]?\d)(?:\/\d+)?\s+(?:\*|[01]?\d|2[0-3])(?:\/\d+)?\s+(?:\*|0?[1-9]|[12]\d|3[01])(?:\/\d+)?\s+(?:\*|0?[1-9]|1[0-2])(?:\/\d+)?\s+(?:\*|[0-6])(?:\/\d+)?/`.
 * - Relies on regex filtering only (no additional validator).
 */
class CronExpressionProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?:\*|[0-5]?\d)(?:\/\d+)?\s+(?:\*|[01]?\d|2[0-3])(?:\/\d+)?\s+(?:\*|0?[1-9]|[12]\d|3[01])(?:\/\d+)?\s+(?:\*|0?[1-9]|1[0-2])(?:\/\d+)?\s+(?:\*|[0-6])(?:\/\d+)?/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRON_EXPRESSION
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRON_EXPRESSION;
    }
}
