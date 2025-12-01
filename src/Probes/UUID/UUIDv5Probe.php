<?php

namespace TextProbe\Probes\UUID;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts version 5 UUIDs from text.
 *
 * This probe matches UUIDs with the version nibble set to "5" in the time_hi_and_version
 * field (xxxxxxxx-xxxx-5xxx-xxxx-xxxxxxxxxxxx), which are generated using SHA-1 hashing
 * of a name and namespace.
 */
class UUIDv5Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{8}-[0-9a-f]{4}-5[0-9a-f]{3}-[0-9a-f]{4}-[0-9a-f]{12}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UUID_V5
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UUID_V5;
    }
}
