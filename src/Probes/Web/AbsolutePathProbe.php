<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts absolute paths starting from the root.
 */
class AbsolutePathProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\/[\S]*$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ABSOLUTE_PATH
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ABSOLUTE_PATH;
    }
}
