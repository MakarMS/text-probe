<?php

namespace TextProbe\Probes\Finance\Swift;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts SWIFT field 20 references.
 */
class SwiftField20ReferenceProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<![A-Za-z0-9\/-])[A-Z0-9][A-Z0-9\/-]{4,14}[A-Z0-9](?![A-Za-z0-9\/-])/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SWIFT_FIELD20_REFERENCE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SWIFT_FIELD20_REFERENCE;
    }
}
