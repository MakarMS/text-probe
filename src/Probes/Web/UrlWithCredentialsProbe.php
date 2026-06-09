<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts URLs that embed user credentials.
 *
 * Examples:
 * - valid: `https://user:pass@example.com/path`
 * - valid: `postgres://dbuser:secret@localhost:5432/app`
 *
 * Constraints:
 * - Requires `scheme://user:password@host...` with non-space user and password parts. It does not percent-decode credentials, validate the host, connect to the service, or distinguish test credentials from real secrets.
 * - Uses regex pattern `~\b[a-z][a-z0-9+.-]*://[^\s/@:]+:[^\s/@]+@[^\s<>"\'),]+~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class UrlWithCredentialsProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b[a-z][a-z0-9+.-]*://[^\\s/@:]+:[^\\s/@]+@[^\\s<>"\'),]+~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::URL_WITH_CREDENTIALS
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::URL_WITH_CREDENTIALS;
    }
}
