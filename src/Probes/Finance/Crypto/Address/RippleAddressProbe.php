<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class RippleAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<![A-Za-z0-9])r[1-9A-HJ-NP-Za-km-z]{25,34}(?![A-Za-z0-9])/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_RIPPLE_ADDRESS;
    }
}
