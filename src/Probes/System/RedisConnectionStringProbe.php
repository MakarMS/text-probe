<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Redis Connection String values from text.
 *
 * Examples:
 * - valid: `redis://:pass@localhost:6379/0`
 * - invalid: `rd://localhost`
 *
 * Constraints:
 * - Uses regex pattern `~redis://[^\s]+~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class RedisConnectionStringProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~redis://[^\s]+~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::REDIS_CONNECTION_STRING
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::REDIS_CONNECTION_STRING;
    }
}
