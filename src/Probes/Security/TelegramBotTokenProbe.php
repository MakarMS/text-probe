<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Telegram bot tokens (`digits:secret`).
 *
 * Examples:
 * - valid: `123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdef1234`
 * - valid: `9876543210:abcdefghijklmnopqrstuvwxyzABCDE_12345`
 *
 * Constraints:
 * - Requires a 6-12 digit bot identifier, a colon, and at least 30 secret characters. It does not call Telegram Bot API, validate the bot ID, or verify token activity.
 * - Uses regex pattern `~\b\d{6,12}:[A-Za-z0-9_-]{30,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class TelegramBotTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b\\d{6,12}:[A-Za-z0-9_-]{30,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::TELEGRAM_BOT_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TELEGRAM_BOT_TOKEN;
    }
}
