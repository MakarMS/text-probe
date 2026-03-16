<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Html Script Src values from text.
 *
 * Examples:
 * - valid: `<script src="/app.js"></script>`
 * - invalid: `<script>var x=1;</script>`
 *
 * Constraints:
 * - Uses regex pattern `~<script\b[^>]*\bsrc=["'][^"']+["'][^>]*>.*?</script>~is`.
 * - Relies on regex filtering only (no additional validator).
 */
class HtmlScriptSrcProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~<script\b[^>]*\bsrc=["\'][^"\']+["\'][^>]*>.*?</script>~is', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTML_SCRIPT_SRC
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTML_SCRIPT_SRC;
    }
}
