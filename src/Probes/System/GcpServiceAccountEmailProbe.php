<?php

namespace TextProbe\Probes\System;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Google Cloud service account email addresses.
 *
 * Examples:
 * - valid: `service-account@project-id.iam.gserviceaccount.com`
 * - valid: `name.with-dash@my-project-123.iam.gserviceaccount.com`
 *
 * Constraints:
 * - Requires the `iam.gserviceaccount.com` domain. It does not verify that the project or service account exists, validate IAM permissions, or enforce every Google service-account local-part rule.
 * - Uses regex pattern `~\b[A-Za-z0-9._-]+@[A-Za-z0-9-]+\.iam\.gserviceaccount\.com\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class GcpServiceAccountEmailProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b[A-Za-z0-9._-]+@[A-Za-z0-9-]+\\.iam\\.gserviceaccount\\.com\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GCP_SERVICE_ACCOUNT_EMAIL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GCP_SERVICE_ACCOUNT_EMAIL;
    }
}
