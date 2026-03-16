<?php

namespace TextProbe\Probes\DateTime;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Duration Iso8601 values from text.
 *
 * Examples:
 * - valid: `P1DT2H30M`
 * - invalid: `PT`
 *
 * Constraints:
 * - Uses regex pattern `/\bP(?=\d|T\d)(?:\d+Y)?(?:\d+M)?(?:\d+W)?(?:\d+D)?(?:T(?:\d+H)?(?:\d+M)?(?:\d+S)?)?\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class DurationIso8601Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bP(?=\d|T\d)(?:\d+Y)?(?:\d+M)?(?:\d+W)?(?:\d+D)?(?:T(?:\d+H)?(?:\d+M)?(?:\d+S)?)?\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DURATION_ISO8601
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DURATION_ISO8601;
    }
}
