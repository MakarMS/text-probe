<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Mongo Db Connection String values from text.
 *
 * Examples:
 * - valid: `mongodb://user:pass@localhost:27017/app`
 * - invalid: `mongo://localhost`
 *
 * Constraints:
 * - Uses regex pattern `~mongodb(?:\+srv)?://[^\s]+~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class MongoDbConnectionStringProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~mongodb(?:\+srv)?://[^\s]+~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MONGODB_CONNECTION_STRING
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MONGODB_CONNECTION_STRING;
    }
}
