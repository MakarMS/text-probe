<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts npm access tokens (`npm_...`).
 *
 * Examples:
 * - valid: `npm_abcdefghijklmnopqrstuvwxyz`
 * - valid: `npm_ABCDEFGHIJKLMNOPQRSTUVWXYZ123456`
 *
 * Constraints:
 * - Requires `npm_` followed by at least 20 alphanumeric characters. It does not support every historical npm token shape, verify registry access, or inspect token scopes.
 * - Uses regex pattern `~\bnpm_[A-Za-z0-9]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class NpmTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bnpm_[A-Za-z0-9]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NPM_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NPM_TOKEN;
    }
}
