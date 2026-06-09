<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Google OAuth client IDs.
 *
 * Examples:
 * - valid: `123456789012-abcdefghijklmnopqrstuvwxyz.apps.googleusercontent.com`
 * - valid: `9876543210987654321-ABCDEabcde12345_-xyz.apps.googleusercontent.com`
 *
 * Constraints:
 * - Requires a 12+ digit numeric prefix, a hyphenated token segment of at least 20 characters, and `.apps.googleusercontent.com`. It does not query Google Cloud, verify the client exists, or check OAuth consent configuration.
 * - Uses regex pattern `~\b\d{12,}-[A-Za-z0-9_-]{20,}\.apps\.googleusercontent\.com\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class GoogleOAuthClientIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b\\d{12,}-[A-Za-z0-9_-]{20,}\\.apps\\.googleusercontent\\.com\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GOOGLE_OAUTH_CLIENT_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GOOGLE_OAUTH_CLIENT_ID;
    }
}
