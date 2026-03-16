<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Terraform Resource Address values from text.
 *
 * Examples:
 * - valid: `aws_instance.web[0]`
 * - invalid: `aws-instance`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z_][\w]*\.[a-zA-Z_][\w]*(?:\[[0-9]+\])?/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TerraformResourceAddressProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z_][\w]*\.[a-zA-Z_][\w]*(?:\[[0-9]+\])?/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TERRAFORM_RESOURCE_ADDRESS
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TERRAFORM_RESOURCE_ADDRESS;
    }
}
