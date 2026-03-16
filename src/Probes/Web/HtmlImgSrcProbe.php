<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Html Img Src values from text.
 *
 * Examples:
 * - valid: `<img src="/a.png" alt="x">`
 * - invalid: `<img alt="x">`
 *
 * Constraints:
 * - Uses regex pattern `~<img\b[^>]*\bsrc=["'][^"']+["'][^>]*>~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class HtmlImgSrcProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('~<img\b[^>]*\bsrc=["\'][^"\']+["\'][^>]*>~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HTML_IMG_SRC
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTML_IMG_SRC;
    }
}
