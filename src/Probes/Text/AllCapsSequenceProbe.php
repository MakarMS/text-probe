<?php

namespace TextProbe\Probes\Text;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts consecutive ALL CAPS sequences from text.
 *
 * Matches runs of two or more uppercase letters (Unicode-aware) that are
 * surrounded by non-word characters, making it suitable for detecting shouts,
 * acronyms, or emphasised uppercase tokens.
 */
class AllCapsSequenceProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b\\p{Lu}{2,}\\b/u', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ALL_CAPS_SEQUENCE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ALL_CAPS_SEQUENCE;
    }
}
