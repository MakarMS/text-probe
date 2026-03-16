<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Rust Crate Name values from text.
 *
 * Examples:
 * - valid: `serde_json`
 * - invalid: `Serde-Json`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-z][a-z0-9_]{1,63}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class RustCrateNameProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-z][a-z0-9_]{1,63}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RUST_CRATE_NAME
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RUST_CRATE_NAME;
    }
}
