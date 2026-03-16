<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Spanish driver licence numbers.
 */
class EsNumeroPermisoConducirProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{8}[A-Z]$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::ES_NUMERO_PERMISO_CONDUCIR
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ES_NUMERO_PERMISO_CONDUCIR;
    }
}
