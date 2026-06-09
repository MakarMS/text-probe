<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Terraform output references.
 *
 * Examples:
 * - valid: `output.endpoint`
 * - valid: `module.api.output.url`
 *
 * Constraints:
 * - Matches `output.name` and `module.name.output.name` with identifier-style names. It does not parse HCL, verify module declarations, or check that an output is defined in state.
 * - Uses regex pattern `/\b(?:module\.[A-Za-z_][A-Za-z0-9_]*\.)?output\.[A-Za-z_][A-Za-z0-9_]*\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TerraformOutputReferenceProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\\b(?:module\\.[A-Za-z_][A-Za-z0-9_]*\\.)?output\\.[A-Za-z_][A-Za-z0-9_]*\\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TERRAFORM_OUTPUT_REFERENCE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TERRAFORM_OUTPUT_REFERENCE;
    }
}
