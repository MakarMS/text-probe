<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts GitHub fine-grained personal access tokens.
 *
 * Matches github_pat_ tokens with base62/underscore tails of at least
 * 30 characters.
 */
class GitHubFineGrainedTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bgithub_pat_[A-Za-z0-9_]{30,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_FINE_GRAINED_TOKEN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_FINE_GRAINED_TOKEN;
    }
}
