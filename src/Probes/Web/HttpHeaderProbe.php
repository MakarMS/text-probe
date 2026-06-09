<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts HTTP-style header lines.
 *
 * Examples:
 * - valid: `X-Request-Id: abc123`
 * - valid: `Accept-Encoding: gzip, br`
 *
 * Constraints:
 * - Matches one complete header line with an RFC-style token name and any non-newline value. It does not unfold continuation lines, parse full HTTP messages, normalize duplicate headers, or validate header-specific value syntax.
 * - Uses regex pattern `/(?m)^[!#$%&\'*+.^_`|~0-9A-Za-z-]+:\h*[^\r\n]*$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class HttpHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[!#$%&\'*+.^_`|~0-9A-Za-z-]+:\\h*[^\\r\\n]*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTTP_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTTP_HEADER;
    }
}
