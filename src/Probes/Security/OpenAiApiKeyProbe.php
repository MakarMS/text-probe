<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts OpenAI API keys (`sk-...` and `sk-proj-...`).
 *
 * Examples:
 * - valid: `sk-proj-abcdefghijklmnopqrstuvwxyz_123456`
 * - valid: `sk-abcdefghijklmnopqrstuvwxyz1234567890`
 *
 * Constraints:
 * - Requires `sk-` with an optional `proj-` segment and at least 20 token characters (`A-Z`, `a-z`, digits, `_`, `-`). It does not call OpenAI, detect revocation, or validate organization/project ownership.
 * - Uses regex pattern `~\bsk-(?:proj-)?[A-Za-z0-9_-]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class OpenAiApiKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bsk-(?:proj-)?[A-Za-z0-9_-]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OPENAI_API_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OPENAI_API_KEY;
    }
}
