<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts German Handelsregisternummer identifiers.
 */
class DeHandelsregisternummerProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^HR[AB]\s?\d{1,6}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::DE_HANDELSREGISTERNUMMER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DE_HANDELSREGISTERNUMMER;
    }
}
