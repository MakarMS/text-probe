<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts PyPI API tokens (`pypi-...`).
 *
 * Examples:
 * - valid: `pypi-abcdefghijklmnopqrstuvwxyz_123456`
 * - valid: `pypi-ABCDEFGHIJKLMNOPQRSTUVWXYZ-123456`
 *
 * Constraints:
 * - Requires `pypi-` followed by at least 20 token characters. It does not decode the token body, call PyPI, or validate project-scoped permissions.
 * - Uses regex pattern `~\bpypi-[A-Za-z0-9_-]{20,}\b~`.
 * - Relies on regex filtering only (no additional validator).
 */
class PypiTokenProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('~\\bpypi-[A-Za-z0-9_-]{20,}\\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PYPI_TOKEN
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PYPI_TOKEN;
    }
}
