<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts ETag HTTP headers.
 *
 * Examples:
 * - valid: `ETag: "abc123"`
 * - valid: `ETag: W/"weak-value"`
 *
 * Constraints:
 * - Requires a quoted entity tag with optional `W/` weak prefix. It does not compare ETags, parse full cache semantics, or handle malformed/multiline header values.
 * - Uses regex pattern `/(?mi)^ETag:\h*(?:W\/)?\"[^\"\r\n]*\"$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class EtagHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^ETag:\\h*(?:W\\/)?\\"[^\\"\\r\\n]*\\"$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ETAG_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ETAG_HEADER;
    }
}
