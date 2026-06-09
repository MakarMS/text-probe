<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts canonical link tags.
 *
 * Examples:
 * - valid: `<link rel="canonical" href="https://example.com/page">`
 * - valid: `<link href="https://example.com/" rel="canonical">`
 *
 * Constraints:
 * - Requires one `<link>` tag with `rel="canonical"` and an absolute `http` or `https` `href`. It does not resolve relative URLs, parse the DOM, validate redirects, or choose among multiple canonical links.
 * - Uses regex pattern `~<link\b(?=[^>]*\brel=["\']canonical["\'])(?=[^>]*\bhref=["\']https?://[^"\']+["\'])[^>]*>~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class CanonicalLinkProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<link\\b(?=[^>]*\\brel=["\']canonical["\'])(?=[^>]*\\bhref=["\']https?://[^"\']+["\'])[^>]*>~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CANONICAL_LINK
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CANONICAL_LINK;
    }
}
