<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Open Graph meta tags.
 *
 * Examples:
 * - valid: `<meta property="og:title" content="Title">`
 * - valid: `<meta content="Site" property="og:site_name">`
 *
 * Constraints:
 * - Requires one `<meta>` tag containing both a `property="og:..."` attribute and a `content` attribute. It is regex-based, so it does not parse malformed HTML, decoded entities, or dynamically generated tags.
 * - Uses regex pattern `~<meta\b(?=[^>]*\bproperty=["\']og:[^"\']+["\'])(?=[^>]*\bcontent=["\'][^"\']*["\'])[^>]*>~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class OpenGraphMetaProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<meta\\b(?=[^>]*\\bproperty=["\']og:[^"\']+["\'])(?=[^>]*\\bcontent=["\'][^"\']*["\'])[^>]*>~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OPEN_GRAPH_META
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OPEN_GRAPH_META;
    }
}
