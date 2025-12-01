<?php

namespace TextProbe\Probes\UUID;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts version 3 UUIDs from text.
 *
 * This probe matches UUIDs with the version nibble set to "3" in the time_hi_and_version
 * field (xxxxxxxx-xxxx-3xxx-xxxx-xxxxxxxxxxxx), which are generated using MD5 hashing
 * of a name and namespace.
 */
class UUIDv3Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{8}-[0-9a-f]{4}-3[0-9a-f]{3}-[0-9a-f]{4}-[0-9a-f]{12}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UUID_V3
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UUID_V3;
    }
}
