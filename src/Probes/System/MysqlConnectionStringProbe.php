<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Mysql Connection String values from text.
 *
 * Examples:
 * - valid: `mysql://user:pass@localhost:3306/app`
 * - invalid: `my://localhost`
 *
 * Constraints:
 * - Uses regex pattern `~mysql://[^\s]+~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class MysqlConnectionStringProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~mysql://[^\s]+~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MYSQL_CONNECTION_STRING
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MYSQL_CONNECTION_STRING;
    }
}
