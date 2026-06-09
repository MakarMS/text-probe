<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Authorization HTTP headers.
 *
 * Examples:
 * - valid: `Authorization: Bearer abc.def.ghi`
 * - valid: `Authorization: Basic dXNlcjpwYXNz`
 *
 * Constraints:
 * - Supports `Bearer`, `Basic`, `Digest`, and `ApiKey` schemes. It does not base64-decode Basic credentials, verify JWTs, validate Digest parameters, or contact an identity provider.
 * - Uses regex pattern `/(?mi)^Authorization:\h*(?:Bearer\h+[A-Za-z0-9._~+\/-]+=*|Basic\h+[A-Za-z0-9+\/]+=*|Digest\h+[^\r\n]+|ApiKey\h+[^\r\n]+)$/`.
 * - Relies on regex filtering only (no additional validator).
 */
class AuthorizationHeaderProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?mi)^Authorization:\\h*(?:Bearer\\h+[A-Za-z0-9._~+\\/-]+=*|Basic\\h+[A-Za-z0-9+\\/]+=*|Digest\\h+[^\\r\\n]+|ApiKey\\h+[^\\r\\n]+)$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::AUTHORIZATION_HEADER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::AUTHORIZATION_HEADER;
    }
}
