<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Kafka Bootstrap Server values from text.
 *
 * Examples:
 * - valid: `kafka1.local:9092,kafka2.local:9092`
 * - invalid: `kafka1.local`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z0-9.-]+:\d{2,5}(?:,[a-zA-Z0-9.-]+:\d{2,5})+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class KafkaBootstrapServerProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z0-9.-]+:\d{2,5}(?:,[a-zA-Z0-9.-]+:\d{2,5})+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::KAFKA_BOOTSTRAP_SERVER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::KAFKA_BOOTSTRAP_SERVER;
    }
}
