<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Youtube Channel Url values from text.
 *
 * Examples:
 * - valid: `https://www.youtube.com/@mychannel`
 * - invalid: `https://youtube.com/watch?v=1`
 *
 * Constraints:
 * - Uses regex pattern `~https?://(?:www\.)?youtube\.com/(?:channel/[A-Za-z0-9_-]{24}|@[A-Za-z0-9._-]{3,30})/?~i`.
 * - Relies on regex filtering only (no additional validator).
 */
class YoutubeChannelUrlProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~https?://(?:www\.)?youtube\.com/(?:channel/[A-Za-z0-9_-]{24}|@[A-Za-z0-9._-]{3,30})/?~i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::YOUTUBE_CHANNEL_URL
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::YOUTUBE_CHANNEL_URL;
    }
}
