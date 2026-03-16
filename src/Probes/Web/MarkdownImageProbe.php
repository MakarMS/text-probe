<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Markdown Image values from text.
 *
 * Examples:
 * - valid: `![logo](https://example.com/logo.png)`
 * - invalid: `[logo](https://example.com/logo.png)`
 *
 * Constraints:
 * - Uses regex pattern `/!\[[^\]]*\]\((https?:\/\/[^\s)]+)\)/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class MarkdownImageProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/!\[[^\]]*\]\((https?:\/\/[^\s)]+)\)/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MARKDOWN_IMAGE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MARKDOWN_IMAGE;
    }
}
