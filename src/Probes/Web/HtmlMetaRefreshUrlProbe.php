<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Html Meta Refresh Url values from text.
 *
 * Examples:
 * - valid: `<meta http-equiv="refresh" content="0;url=https://example.com">`
 * - invalid: `<meta charset="utf-8">`
 *
 * Constraints:
 * - Uses regex pattern `~<meta\b[^>]*http-equiv=["']refresh["'][^>]*content=["'][^"']*url=[^"']+["'][^>]*>~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class HtmlMetaRefreshUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<meta\b[^>]*http-equiv=["\']refresh["\'][^>]*content=["\'][^"\']*url=[^"\']+["\'][^>]*>~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTML_META_REFRESH_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTML_META_REFRESH_URL;
    }
}
