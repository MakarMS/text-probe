<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Elasticsearch Url values from text.
 *
 * Examples:
 * - valid: `http://localhost:9200/_cluster/health`
 * - invalid: `http://localhost:9300`
 *
 * Constraints:
 * - Uses regex pattern `~https?://[A-Za-z0-9.-]+:9200\b[^\s]*~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class ElasticsearchUrlProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://[A-Za-z0-9.-]+:9200\b[^\s]*~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ELASTICSEARCH_URL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ELASTICSEARCH_URL;
    }
}
