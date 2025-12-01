<?php

namespace TextProbe\Probes\Contact\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Telegram usernames (e.g. "@username").
 *
 * This probe matches Telegram-style handles starting with "@" and enforces
 * basic constraints on allowed characters and length (5–32 characters).
 */
class TelegramUsernameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/@[a-zA-Z0-9_]{5,32}/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TELEGRAM_USERNAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TELEGRAM_USERNAME;
    }
}
