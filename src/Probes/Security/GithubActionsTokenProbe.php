<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Github Actions Token values from text.
 *
 * Examples:
 * - valid: `ghs_1234567890123456789012345`
 * - invalid: `ghp_12345`
 *
 * Constraints:
 * - Uses regex pattern `/\bgh[rs]_[A-Za-z0-9]{20,255}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class GithubActionsTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bgh[rs]_[A-Za-z0-9]{20,255}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GITHUB_ACTIONS_TOKEN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GITHUB_ACTIONS_TOKEN;
    }
}
