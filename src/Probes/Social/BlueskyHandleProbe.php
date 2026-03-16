<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Bluesky Handle values from text.
 *
 * Examples:
 * - valid: `maker.bsky.social`
 * - invalid: `maker.bsky`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z0-9][a-z0-9-]{0,62}\.bsky\.social\b/i`.
 * - Relies on regex filtering only (no additional validator).
 */
class BlueskyHandleProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z0-9][a-z0-9-]{0,62}\.bsky\.social\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::BLUESKY_HANDLE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BLUESKY_HANDLE;
    }
}
