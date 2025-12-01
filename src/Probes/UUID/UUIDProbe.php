<?php

namespace TextProbe\Probes\UUID;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts generic UUIDs from text.
 *
 * This probe matches standard 36-character UUID strings with hyphens
 * (xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx) and does not enforce a specific
 * version, allowing v1–v6 and other variants.
 */
class UUIDProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UUID
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UUID;
    }
}
