<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts semantic version numbers from text.
 *
 * Matches versions in the MAJOR.MINOR.PATCH form with optional pre-release
 * identifiers and build metadata, following the semantic versioning 2.0.0
 * specification. Numeric identifiers disallow leading zeros, while alphanumeric
 * identifiers support hyphens and dot-separated segments.
 */
class SemanticVersionProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $number = '(?:0|[1-9]\d*)';
        $label = '[0-9A-Za-z-]+';

        $regex = '/(?<![0-9A-Za-z.])'
            . $number . '\.' . $number . '\.' . $number
            . '(?:-' . $label . '(?:\.' . $label . ')*)?'
            . '(?:\+' . $label . '(?:\.' . $label . ')*)?'
            . '(?!\.\d)'
            . '(?![0-9A-Za-z])'
            . '/u';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::SEMANTIC_VERSION
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SEMANTIC_VERSION;
    }
}
