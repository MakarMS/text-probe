<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Reddit Username values from text.
 *
 * Examples:
 * - valid: `u/reddit_user`
 * - invalid: `u/ab`
 *
 * Constraints:
 * - Uses regex pattern `~(?:u/[A-Za-z0-9_-]{3,20}|https?://(?:www\.)?reddit\.com/user/[A-Za-z0-9_-]{3,20})~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class RedditUsernameProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~(?:u/[A-Za-z0-9_-]{3,20}|https?://(?:www\.)?reddit\.com/user/[A-Za-z0-9_-]{3,20})~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::REDDIT_USERNAME
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::REDDIT_USERNAME;
    }
}
