<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Mastodon Handle values from text.
 *
 * Examples:
 * - valid: `@alice@mastodon.social`
 * - invalid: `@alice@localhost`
 *
 * Constraints:
 * - Uses regex pattern `/(?<!\w)@[A-Za-z0-9_]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class MastodonHandleProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\w)@[A-Za-z0-9_]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::MASTODON_HANDLE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MASTODON_HANDLE;
    }
}
