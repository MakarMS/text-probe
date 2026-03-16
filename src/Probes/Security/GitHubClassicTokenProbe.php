<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts GitHub classic personal access tokens.
 *
 * Matches ghp_ tokens with base62 tails of at least 30 characters.
 */
class GitHubClassicTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bghp_[A-Za-z0-9]{30,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_CLASSIC_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_CLASSIC_TOKEN;
    }
}
