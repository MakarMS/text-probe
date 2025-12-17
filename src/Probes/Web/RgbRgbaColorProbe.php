<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Web\RgbRgbaColorValidator;

/**
 * Probe that extracts colors in RGB or RGBA notation.
 *
 * This probe supports:
 * - CSS-like functions such as `rgb(255, 0, 0)` and `rgba(12,34,56,0.5)` with
 *   optional whitespace between components.
 * - Bare comma-separated triplets like `255,0,0` commonly used in data dumps or
 *   configuration files.
 *
 * Matched values are validated to ensure RGB channels fall within 0–255 and
 * the optional alpha channel remains between 0 and 1.
 */
class RgbRgbaColorProbe extends Probe implements IProbe
{
    public function __construct()
    {
        parent::__construct(new RgbRgbaColorValidator());
    }

    public function probe(string $text): array
    {
        $pattern = '/(?<![0-9A-Za-z])(?:'
            . 'rgba\s*\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*[0-9]*\.?[0-9]+\s*\)'
            . '|'
            . 'rgb\s*\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*\)'
            . '|'
            . '(?<!rgba\()(?<!rgb\()(?<!\d)\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}'
            . ')(?![0-9A-Za-z])/i';

        return $this->findByRegex($pattern, $text);
    }

    /**
     * @return ProbeType returns ProbeType::COLOR
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RGB_RGBA_COLOR;
    }
}
