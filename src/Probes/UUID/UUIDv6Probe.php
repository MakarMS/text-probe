<?php

namespace TextProbe\Probes\UUID;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts version 6 UUIDs from text.
 *
 * This probe matches UUIDs with the version nibble set to "6" in the time_hi_and_version
 * field (xxxxxxxx-xxxx-6xxx-xxxx-xxxxxxxxxxxx), an ordered variant designed to improve
 * sorting and indexing characteristics compared to earlier versions.
 */
class UUIDv6Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{8}-[0-9a-f]{4}-6[0-9a-f]{3}-[0-9a-f]{4}-[0-9a-f]{12}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UUID_V6
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UUID_V6;
    }
}
