<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Terraform S3 backend declarations.
 *
 * Examples:
 * - valid: `backend "s3"`
 * - valid: `backend    "s3"`
 *
 * Constraints:
 * - Detects the `backend "s3"` declaration text only. It does not parse the backend block body, validate bucket/table/key settings, or check AWS access.
 * - Uses regex pattern `/backend\s+"s3"/`.
 * - Relies on regex filtering only (no additional validator).
 */
class TerraformBackendS3Probe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/backend\\s+"s3"/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TERRAFORM_BACKEND_S3
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TERRAFORM_BACKEND_S3;
    }
}
