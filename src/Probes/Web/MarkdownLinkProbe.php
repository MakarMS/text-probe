<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Markdown Link values from text.
 *
 * Examples:
 * - valid: `[docs](https://example.com/docs)`
 * - invalid: `plain link`
 *
 * Constraints:
 * - Uses regex pattern `/\[[^\]]+\]\((https?:\/\/[^\s)]+)\)/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class MarkdownLinkProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\[[^\]]+\]\((https?:\/\/[^\s)]+)\)/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MARKDOWN_LINK
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MARKDOWN_LINK;
    }
}
