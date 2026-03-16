<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Http Request Line values from text.
 *
 * Examples:
 * - valid: `GET /health HTTP/1.1`
 * - invalid: `FETCH /health HTTP/1.1`
 *
 * Constraints:
 * - Uses regex pattern `/(?:GET|POST|PUT|PATCH|DELETE|HEAD|OPTIONS)\s+\S+\s+HTTP\/\d\.\d/`.
 * - Relies on regex filtering only (no additional validator).
 */
class HttpRequestLineProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?:GET|POST|PUT|PATCH|DELETE|HEAD|OPTIONS)\s+\S+\s+HTTP\/\d\.\d/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTTP_REQUEST_LINE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTTP_REQUEST_LINE;
    }
}
