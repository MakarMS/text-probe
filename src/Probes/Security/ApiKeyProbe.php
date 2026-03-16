<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts API keys for common providers.
 *
 * Matches Stripe keys, GitHub tokens, Google API keys, and AWS access key IDs
 * by known prefixes.
 */
class ApiKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $patterns = [
            'sk_(?:live|test)_[A-Za-z0-9]{16,}',
            'pk_(?:live|test)_[A-Za-z0-9]{16,}',
            'ghp_[A-Za-z0-9]{30,}',
            'github_pat_[A-Za-z0-9_]{30,}',
            'AIza[0-9A-Za-z\-_]{30,}',
            '(?:AKIA|ASIA)[0-9A-Z]{16}',
        ];

        return $this->findByRegex('/\b(?:' . implode('|', $patterns) . ')\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::API_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::API_KEY;
    }
}
