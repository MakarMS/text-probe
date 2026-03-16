<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Ansible Variable values from text.
 *
 * Examples:
 * - valid: `{{ inventory_hostname }}`
 * - invalid: `{ inventory_hostname }`
 *
 * Constraints:
 * - Uses regex pattern `/\{\{\s*[a-zA-Z_][\w.]*\s*\}\}/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AnsibleVariableProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\{\{\s*[a-zA-Z_][\w.]*\s*\}\}/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ANSIBLE_VARIABLE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ANSIBLE_VARIABLE;
    }
}
