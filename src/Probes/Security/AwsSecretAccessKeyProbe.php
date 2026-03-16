<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Aws Secret Access Key values from text.
 *
 * Examples:
 * - valid: `wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY`
 * - invalid: `short_secret_key`
 *
 * Constraints:
 * - Uses regex pattern `/\b[A-Za-z0-9\/+]{40}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AwsSecretAccessKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Za-z0-9\/+]{40}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AWS_SECRET_ACCESS_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AWS_SECRET_ACCESS_KEY;
    }
}
