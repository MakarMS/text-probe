<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Twitter Card meta tags.
 *
 * Examples:
 * - valid: `<meta name="twitter:card" content="summary">`
 * - valid: `<meta content="@user" name="twitter:site">`
 *
 * Constraints:
 * - Requires one `<meta>` tag with `name="twitter:..."` and `content`. It does not validate allowed Twitter Card names, parse DOM trees, decode entities, or fetch referenced media.
 * - Uses regex pattern `~<meta\b(?=[^>]*\bname=["\']twitter:[^"\']+["\'])(?=[^>]*\bcontent=["\'][^"\']*["\'])[^>]*>~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class TwitterCardMetaProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<meta\\b(?=[^>]*\\bname=["\']twitter:[^"\']+["\'])(?=[^>]*\\bcontent=["\'][^"\']*["\'])[^>]*>~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TWITTER_CARD_META
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TWITTER_CARD_META;
    }
}
