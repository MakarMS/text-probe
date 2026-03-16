<?php

namespace TextProbe\Probes\Software;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Yaml Key Path values from text.
 *
 * Examples:
 * - valid: `app.database.host`
 * - invalid: `app`
 *
 * Constraints:
 * - Uses regex pattern `/\b[a-zA-Z_][\w-]*(?:\.[a-zA-Z_][\w-]*)+\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class YamlKeyPathProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-zA-Z_][\w-]*(?:\.[a-zA-Z_][\w-]*)+\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::YAML_KEY_PATH
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::YAML_KEY_PATH;
    }
}
