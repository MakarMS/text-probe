<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Google service account email addresses.
 *
 * Examples:
 * - valid: `service-account@project-id.iam.gserviceaccount.com`
 * - valid: `name.with-dash@my-project-123.iam.gserviceaccount.com`
 *
 * Constraints:
 * - Requires the `*.iam.gserviceaccount.com` domain and a simple project-id host segment. It does not validate that the project exists, that the service account exists, or that the local part follows every Google Cloud naming rule.
 * - Uses regex pattern `~\b[A-Za-z0-9._-]+@[A-Za-z0-9-]+\.iam\.gserviceaccount\.com\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class GoogleServiceAccountEmailProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b[A-Za-z0-9._-]+@[A-Za-z0-9-]+\\.iam\\.gserviceaccount\\.com\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GOOGLE_SERVICE_ACCOUNT_EMAIL;
    }
}
