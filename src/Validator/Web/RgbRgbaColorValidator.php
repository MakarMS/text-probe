<?php

namespace TextProbe\Validator\Web;

use TextProbe\Validator\Contracts\IValidator;

/**
 * Validator for RGB/RGBA color strings.
 *
 * Ensures each RGB component is between 0 and 255 (inclusive) and, when
 * present, that the alpha channel is a numeric value between 0 and 1
 * (inclusive).
 */
class RgbRgbaColorValidator implements IValidator
{
    public function validate(string $raw): bool
    {
        $trimmed = trim($raw);

        if ($this->isRgb($trimmed)) {
            return true;
        }

        if ($this->isRgba($trimmed)) {
            return true;
        }

        return $this->isPlainRgb($trimmed);
    }

    private function isRgb(string $raw): bool
    {
        if (preg_match('/^rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/i', $raw, $matches) !== 1) {
            return false;
        }

        return $this->channelsAreValid([$matches[1], $matches[2], $matches[3]]);
    }

    private function isRgba(string $raw): bool
    {
        if (preg_match('/^rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*([0-9]*\.?[0-9]+)\s*\)$/i', $raw, $matches) !== 1) {
            return false;
        }

        if (!$this->channelsAreValid([$matches[1], $matches[2], $matches[3]])) {
            return false;
        }

        return $this->alphaIsValid($matches[4]);
    }

    private function isPlainRgb(string $raw): bool
    {
        if (preg_match('/^(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})$/', $raw, $matches) !== 1) {
            return false;
        }

        return $this->channelsAreValid([$matches[1], $matches[2], $matches[3]]);
    }

    /**
     * @param array<int, string> $channels
     */
    private function channelsAreValid(array $channels): bool
    {
        foreach ($channels as $channel) {
            $value = (int) $channel;

            if ($value < 0 || $value > 255) {
                return false;
            }
        }

        return true;
    }

    private function alphaIsValid(string $alpha): bool
    {
        if (!is_numeric($alpha)) {
            return false;
        }

        $value = (float) $alpha;

        return $value >= 0.0 && $value <= 1.0;
    }
}
