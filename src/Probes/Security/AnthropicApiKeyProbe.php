<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Anthropic API keys (`sk-ant-api03-...`).
 *
 * Examples:
 * - valid: `sk-ant-api03-abcdefghijklmnopqrstuvwxyz_123456`
 * - valid: `sk-ant-api03-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456`
 *
 * Constraints:
 * - Requires the `sk-ant-api03-` prefix and at least 20 token characters. It does not call Anthropic APIs, validate live credentials, or check workspace ownership.
 * - Uses regex pattern `~\bsk-ant-api03-[A-Za-z0-9_-]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class AnthropicApiKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bsk-ant-api03-[A-Za-z0-9_-]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ANTHROPIC_API_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ANTHROPIC_API_KEY;
    }
}
