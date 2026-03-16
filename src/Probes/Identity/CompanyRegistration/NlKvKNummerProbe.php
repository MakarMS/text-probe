<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Dutch KvK numbers.
 */
class NlKvKNummerProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{8}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NL_KVK_NUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NL_KVK_NUMMER;
    }
}
