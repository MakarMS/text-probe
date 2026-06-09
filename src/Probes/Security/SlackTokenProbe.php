<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Slack app and bot tokens (`xox...` and `xapp-...`).
 *
 * Examples:
 * - valid: `xoxb-123456789012-123456789012-abcdefghijklmnopqrstuv`
 * - valid: `xapp-1-A1234567890-1234567890123-abcdef1234567890abcdef1234567890`
 *
 * Constraints:
 * - Supports `xoxb`, `xoxa`, `xoxp`, `xoxr`, `xoxs`, and `xapp`-style prefixes with hyphenated token bodies. It does not validate Slack workspace IDs, app IDs, scopes, expiration, or revocation.
 * - Uses regex pattern `~\bx(?:ox[baprs]|app)-[A-Za-z0-9-]{10,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class SlackTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bx(?:ox[baprs]|app)-[A-Za-z0-9-]{10,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SLACK_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SLACK_TOKEN;
    }
}
