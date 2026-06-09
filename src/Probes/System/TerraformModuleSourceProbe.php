<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Terraform module sources.
 *
 * Examples:
 * - valid: `terraform-aws-modules/vpc/aws`
 * - valid: `git::https://github.com/org/module.git`
 *
 * Constraints:
 * - Supports registry-style `namespace/name/provider` and `git::http(s)://...` sources. It does not run `terraform init`, validate registry modules, parse query parameters semantically, or support every Terraform source scheme.
 * - Uses regex pattern `~\b(?:git::https?://[^\s]+|[A-Za-z0-9_-]+/[A-Za-z0-9_-]+/[A-Za-z0-9_-]+)\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class TerraformModuleSourceProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b(?:git::https?://[^\\s]+|[A-Za-z0-9_-]+/[A-Za-z0-9_-]+/[A-Za-z0-9_-]+)\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TERRAFORM_MODULE_SOURCE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TERRAFORM_MODULE_SOURCE;
    }
}
