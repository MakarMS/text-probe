<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Jenkins Api Token values from text.
 *
 * Examples:
 * - valid: `0123456789abcdef0123456789abcdef`
 * - invalid: `0123456789abcdef`
 *
 * Constraints:
 * - Uses regex pattern `/\b[0-9a-f]{32}\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class JenkinsApiTokenProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{32}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::JENKINS_API_TOKEN
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::JENKINS_API_TOKEN;
    }
}
