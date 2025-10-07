<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class UsdtOmniAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[13][a-zA-HJ-NP-Z0-9]{25,34}\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDT_OMNI_ADDRESS;
    }
}
