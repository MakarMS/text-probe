<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Terraform Variable Reference values from text.
 *
 * Examples:
 * - valid: `var.environment`
 * - invalid: `vars.environment`
 *
 * Constraints:
 * - Uses regex pattern `/\bvar\.[a-zA-Z_][\w]*\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TerraformVariableReferenceProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bvar\.[a-zA-Z_][\w]*\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TERRAFORM_VARIABLE_REFERENCE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TERRAFORM_VARIABLE_REFERENCE;
    }
}
