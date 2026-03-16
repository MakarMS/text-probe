<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Postgres Connection String values from text.
 *
 * Examples:
 * - valid: `postgres://user:pass@localhost:5432/app`
 * - invalid: `pg://localhost`
 *
 * Constraints:
 * - Uses regex pattern `~postgres(?:ql)?://[^\s]+~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class PostgresConnectionStringProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('~postgres(?:ql)?://[^\s]+~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::POSTGRES_CONNECTION_STRING
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::POSTGRES_CONNECTION_STRING;
    }
}
