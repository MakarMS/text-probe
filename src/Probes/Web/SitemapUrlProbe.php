<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts sitemap XML URLs.
 *
 * Examples:
 * - valid: `https://example.com/sitemap.xml`
 * - valid: `https://example.com/sitemap-news.xml`
 *
 * Constraints:
 * - Matches absolute `http` or `https` URLs whose path ends in `sitemap.xml` or `sitemap-*.xml`/`sitemap_*.xml`. It does not fetch the sitemap, parse XML, or detect sitemap indexes with other filenames.
 * - Uses regex pattern `~\bhttps?://[^\s<>"\']*\/sitemap(?:[_-][A-Za-z0-9-]+)?\.xml\b~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class SitemapUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bhttps?://[^\\s<>"\']*/sitemap(?:[_-][A-Za-z0-9-]+)?\\.xml\\b~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SITEMAP_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SITEMAP_URL;
    }
}
