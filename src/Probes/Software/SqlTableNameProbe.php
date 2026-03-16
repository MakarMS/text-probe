<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Sql Table Name values from text.
 *
 * Examples:
 * - valid: `SELECT * FROM users`
 * - invalid: `SELECT users`
 *
 * Constraints:
 * - Uses regex pattern `/(?:SELECT\s+\*\s+FROM\s+[A-Za-z_][A-Za-z0-9_.]*|(?:FROM|JOIN|UPDATE|INTO)\s+[A-Za-z_][A-Za-z0-9_.]*)/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class SqlTableNameProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?:SELECT\s+\*\s+FROM\s+[A-Za-z_][A-Za-z0-9_.]*|(?:FROM|JOIN|UPDATE|INTO)\s+[A-Za-z_][A-Za-z0-9_.]*)/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SQL_TABLE_NAME
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SQL_TABLE_NAME;
    }
}
