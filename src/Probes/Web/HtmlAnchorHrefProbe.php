<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Html Anchor Href values from text.
 *
 * Examples:
 * - valid: `<a href="https://example.com">x</a>`
 * - invalid: `<span>no link</span>`
 *
 * Constraints:
 * - Uses regex pattern `~<a\b[^>]*\bhref=["'][^"']+["'][^>]*>.*?</a>~is`.
 * - Relies on regex filtering only (no additional validator).
 */
class HtmlAnchorHrefProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('~<a\b[^>]*\bhref=["\'][^"\']+["\'][^>]*>.*?</a>~is', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTML_ANCHOR_HREF
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTML_ANCHOR_HREF;
    }
}
