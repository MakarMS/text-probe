<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Google OAuth client secrets (`GOCSPX-...`).
 *
 * Examples:
 * - valid: `GOCSPX-abcdefghijklmnopqrstuvwxyz`
 * - valid: `GOCSPX-ABCDEFGHIJKLMNOPQRSTUVWXYZ123456`
 *
 * Constraints:
 * - Requires `GOCSPX-` followed by at least 20 token characters. It does not verify the secret against Google, detect rotation, or identify the related OAuth client.
 * - Uses regex pattern `~\bGOCSPX-[A-Za-z0-9_-]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class GoogleOAuthClientSecretProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bGOCSPX-[A-Za-z0-9_-]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GOOGLE_OAUTH_CLIENT_SECRET
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GOOGLE_OAUTH_CLIENT_SECRET;
    }
}
