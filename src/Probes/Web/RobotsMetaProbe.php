<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts robots meta tags.
 *
 * Examples:
 * - valid: `<meta name="robots" content="noindex,nofollow">`
 * - valid: `<meta content="index,follow" name="robots">`
 *
 * Constraints:
 * - Requires one `<meta>` tag with `name="robots"` and `content`. It does not validate directive names, combine multiple robot directives, parse `X-Robots-Tag` headers, or evaluate crawler behavior.
 * - Uses regex pattern `~<meta\b(?=[^>]*\bname=["\']robots["\'])(?=[^>]*\bcontent=["\'][^"\']+["\'])[^>]*>~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class RobotsMetaProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<meta\\b(?=[^>]*\\bname=["\']robots["\'])(?=[^>]*\\bcontent=["\'][^"\']+["\'])[^>]*>~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ROBOTS_META
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ROBOTS_META;
    }
}
