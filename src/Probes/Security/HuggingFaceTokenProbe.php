<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Hugging Face access tokens (`hf_...`).
 *
 * Examples:
 * - valid: `hf_abcdefghijklmnopqrstuvwxyz`
 * - valid: `hf_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456`
 *
 * Constraints:
 * - Requires `hf_` followed by at least 20 alphanumeric characters. It does not support other provider prefixes, query Hugging Face, or verify scopes and revocation state.
 * - Uses regex pattern `~\bhf_[A-Za-z0-9]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class HuggingFaceTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bhf_[A-Za-z0-9]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::HUGGING_FACE_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HUGGING_FACE_TOKEN;
    }
}
