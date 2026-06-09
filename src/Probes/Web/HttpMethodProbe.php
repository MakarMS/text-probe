<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts HTTP method names.
 *
 * Examples:
 * - valid: `GET`
 * - valid: `PATCH`
 *
 * Constraints:
 * - Matches only common uppercase methods: `GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `HEAD`, `OPTIONS`, `TRACE`, and `CONNECT`. It does not parse request lines or support extension methods outside that list.
 * - Uses regex pattern `/\b(?:GET|POST|PUT|PATCH|DELETE|HEAD|OPTIONS|TRACE|CONNECT)\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class HttpMethodProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?:GET|POST|PUT|PATCH|DELETE|HEAD|OPTIONS|TRACE|CONNECT)\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTTP_METHOD
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTTP_METHOD;
    }
}
