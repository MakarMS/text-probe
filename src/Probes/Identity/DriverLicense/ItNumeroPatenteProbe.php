<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Italian driver licence numbers.
 */
class ItNumeroPatenteProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{2}\d{7}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IT_NUMERO_PATENTE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IT_NUMERO_PATENTE;
    }
}
