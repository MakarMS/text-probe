<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Telegram user links in the form of t.me-style URLs.
 *
 * This probe detects profile links such as "https://t.me/username" and
 * similar variants using "telegram.me" or "telegram.dog" domains, with
 * optional query strings or fragments.
 */
class TelegramUserLinkProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/https?:\/\/(?:t\.me|telegram\.me|telegram\.dog)\/[a-zA-Z0-9_]{5,32}(?:[?#]\S*)?/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::TELEGRAM_USER_LINK
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TELEGRAM_USER_LINK;
    }
}
