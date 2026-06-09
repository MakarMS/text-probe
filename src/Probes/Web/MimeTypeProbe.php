<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts MIME type values.
 *
 * Examples:
 * - valid: `application/json`
 * - valid: `text/html; charset=UTF-8`
 *
 * Constraints:
 * - Matches `type/subtype` plus optional semicolon parameters. It does not check the value against an IANA registry, decode quoted parameter semantics beyond simple text, or validate actual file content.
 * - Uses regex pattern `~\b[a-z][a-z0-9!#$&^_.+-]*\/[a-z0-9!#$&^_.+-]+(?:\s*;\s*[a-z0-9_-]+=(?:"[^"]+"|[^\s;]+))*\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class MimeTypeProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b[a-z][a-z0-9!#$&^_.+-]*/[a-z0-9!#$&^_.+-]+(?:\\s*;\\s*[a-z0-9_-]+=(?:"[^"]+"|[^\\s;]+))*\\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MIME_TYPE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MIME_TYPE;
    }
}
