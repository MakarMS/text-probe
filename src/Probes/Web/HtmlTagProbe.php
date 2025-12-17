<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts HTML tags from text.
 *
 * This probe returns full tag representations:
 * - For paired tags, it captures the opening tag, any nested content, and the matching closing tag
 *   (e.g. "<div class=\"box\">content</div>").
 * - For self-closing or single tags, it returns only the tag itself (e.g. "<br>", "<img src=\"image.png\"/>").
 */
class HtmlTagProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(<(?P<pair_tag>[A-Za-z][A-Za-z0-9:-]*)(?:\s+[^<>]*?)?>[^<]*<\/\k<pair_tag>\s*>'
            . '|<(?P<self_closing>[A-Za-z][A-Za-z0-9:-]*)(?:\s+[^<>]*?)?\/>'
            . '|<(?P<single>[A-Za-z][A-Za-z0-9:-]*)(?:\s+[^<>]*?)?>)/u',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::HTML_TAG
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTML_TAG;
    }
}
