<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts AWS access key IDs.
 *
 * Matches AKIA/ASIA prefixes followed by 16 uppercase alphanumeric characters.
 */
class AwsAccessKeyIdProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:AKIA|ASIA)[0-9A-Z]{16}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_ACCESS_KEY_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_ACCESS_KEY_ID;
    }
}
