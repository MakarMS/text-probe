<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts hyperlinks from text.
 *
 * This probe supports:
 * - Absolute URLs with http/https schemes and either domain names or IP/IPv6 literals
 *   (e.g. "https://example.com/path", "http://192.168.0.1/logs", "https://[2001:db8::1]/").
 * - Scheme-less links starting with "www." or bare domains with paths
 *   (e.g. "www.example.com/page", "example.org/docs").
 *
 * It also avoids trailing punctuation like commas or periods at the end of the URL.
 */
class LinkProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?:'
            . 'https?:\/\/(?:\[[0-9a-f:.]+]|\d{1,3}(?:\.\d{1,3}){3}|(?:[a-z0-9-]+\.)+[a-z]{2,})\S*'
            . '|'
            . '(?:www\.|(?:[a-z0-9-]+\.)+[a-z]{2,})(?:\/\S*)?'
            . ')(?<![.,;:!?\s])/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::LINK
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::LINK;
    }
}
