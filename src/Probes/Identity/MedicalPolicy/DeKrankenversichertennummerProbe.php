<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts German Krankenversichertennummer numbers.
 */
class DeKrankenversichertennummerProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DE_KRANKENVERSICHERTENNUMMER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DE_KRANKENVERSICHERTENNUMMER;
    }
}
