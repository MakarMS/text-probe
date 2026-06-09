<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Discord bot tokens in segmented and MFA-like forms.
 *
 * Examples:
 * - valid: `MTA0NzI4NzQ2MjczNDY1NjU1MA.Gabcde.abcdefghijklmnopqrstuvwxyz123456`
 * - valid: `mfa.abcdefghijklmnopqrstuvwxyz1234567890`
 *
 * Constraints:
 * - Matches either `mfa.` plus 20+ token characters or three dot-separated token segments. It does not decode snowflakes, call Discord, or verify that the token is a bot token rather than another Discord-like token.
 * - Uses regex pattern `~\b(?:mfa\.[A-Za-z0-9_-]{20,}|[A-Za-z0-9_-]{20,}\.[A-Za-z0-9_-]{6,}\.[A-Za-z0-9_-]{20,})\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class DiscordBotTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\b(?:mfa\\.[A-Za-z0-9_-]{20,}|[A-Za-z0-9_-]{20,}\\.[A-Za-z0-9_-]{6,}\\.[A-Za-z0-9_-]{20,})\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DISCORD_BOT_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DISCORD_BOT_TOKEN;
    }
}
