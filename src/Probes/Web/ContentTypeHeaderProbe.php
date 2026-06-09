<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Content-Type HTTP headers.
 *
 * Examples:
 * - valid: `Content-Type: application/json`
 * - valid: `Content-Type: text/html; charset=UTF-8`
 *
 * Constraints:
 * - Matches a complete `Content-Type:` line with media type and optional parameters. It does not validate against the IANA registry, parse multipart boundaries, or inspect the payload.
 * - Uses regex pattern `/(?mi)^Content-Type:\h*[a-z][a-z0-9!#$&^_.+-]*\/[a-z0-9!#$&^_.+-]+(?:\h*;\h*[^\r\n;=]+=[^\r\n;]+)*$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class ContentTypeHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^Content-Type:\\h*[a-z][a-z0-9!#$&^_.+-]*\\/[a-z0-9!#$&^_.+-]+(?:\\h*;\\h*[^\\r\\n;=]+=[^\\r\\n;]+)*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CONTENT_TYPE_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CONTENT_TYPE_HEADER;
    }
}
