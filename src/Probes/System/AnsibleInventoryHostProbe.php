<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Ansible inventory host lines.
 *
 * Examples:
 * - valid: `web01 ansible_host=192.0.2.10`
 * - valid: `db01.example.com`
 *
 * Constraints:
 * - Matches a full line with a hostname-like token and optional `ansible_host=...`. It does not parse groups, variables beyond `ansible_host`, YAML inventories, or verify host reachability.
 * - Uses regex pattern `/(?m)^[A-Za-z0-9._-]+(?:\s+ansible_host=\S+)?$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AnsibleInventoryHostProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Za-z0-9._-]+(?:\\s+ansible_host=\\S+)?$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ANSIBLE_INVENTORY_HOST
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ANSIBLE_INVENTORY_HOST;
    }
}
