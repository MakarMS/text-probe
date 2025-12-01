<?php

namespace TextProbe\Probes\UUID;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts version 2 UUIDs from text.
 *
 * This probe matches UUIDs with the version nibble set to "2" in the time_hi_and_version
 * field (xxxxxxxx-xxxx-2xxx-xxxx-xxxxxxxxxxxx), typically used in DCE Security contexts.
 */
class UUIDv2Probe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[0-9a-f]{8}-[0-9a-f]{4}-2[0-9a-f]{3}-[0-9a-f]{4}-[0-9a-f]{12}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UUID_V2
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UUID_V2;
    }
}
