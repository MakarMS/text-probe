<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts absolute file system paths from text.
 *
 * This probe detects Linux-style paths (e.g., /etc/passwd) and Windows-style
 * paths (e.g., C:\\Windows\\System32), applying basic boundaries to avoid
 * partial matches inside longer tokens.
 */
class FilePathProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![\\w\\/\\\\.-])'
            . '(?:'
            . '\\/[A-Za-z0-9._-]+(?:\\/[A-Za-z0-9._-]+)*'
            . '|'
            . '[A-Za-z]:\\\\'
            . '(?:[A-Za-z0-9._-]+(?: [A-Za-z0-9._-]+)*\\\\)*'
            . '[A-Za-z0-9._-]+'
            . ')'
            . '(?![\\w\\/\\\\.-])/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::FILE_PATH
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::FILE_PATH;
    }
}
