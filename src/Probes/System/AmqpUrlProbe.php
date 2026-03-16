<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Amqp Url values from text.
 *
 * Examples:
 * - valid: `amqp://guest:guest@localhost:5672/vh`
 * - invalid: `aqmp://localhost`
 *
 * Constraints:
 * - Uses regex pattern `~amqps?://[^\s]+~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class AmqpUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~amqps?://[^\s]+~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AMQP_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AMQP_URL;
    }
}
