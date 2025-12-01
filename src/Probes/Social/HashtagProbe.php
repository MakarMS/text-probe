<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts hashtags from text.
 *
 * This probe detects words starting with "#" and supports Unicode letters,
 * combining marks, digits and underscores, allowing hashtags to appear in
 * any position within the text.
 */
class HashtagProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/#[\p{L}\p{M}0-9_]+/u', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HASHTAG
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HASHTAG;
    }
}
