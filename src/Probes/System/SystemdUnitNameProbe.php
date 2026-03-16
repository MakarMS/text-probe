<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Systemd Unit Name values from text.
 *
 * Examples:
 * - valid: `nginx.service`
 * - invalid: `nginx.svc`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z0-9@_.-]+\.(?:service|timer|socket|target|mount)\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class SystemdUnitNameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z0-9@_.-]+\.(?:service|timer|socket|target|mount)\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SYSTEMD_UNIT_NAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SYSTEMD_UNIT_NAME;
    }
}
