<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts GitHub repository links from text.
 *
 * Matches HTTP/HTTPS URLs pointing to github.com with owner and repository
 * segments, handling optional ".git" suffixes, additional paths, and trailing
 * punctuation.
 */
class GithubRepositoryLinkProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/https?:\/\/(?:www\.)?github\.com\/[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+(?:\.git)?(?:\/[\w.-]+)*\/?(?:\?[\w\-._~%+&=]*)?(?:#[\w\d\-._~%+&=]*)?(?=[\s\n\r\t.,;:!?)}\]]|$)/i',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_REPOSITORY_LINK
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_REPOSITORY_LINK;
    }
}
