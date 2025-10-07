<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class TronAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bT[1-9A-HJ-NP-Za-km-z]{33}\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_TRON_ADDRESS;
    }
}
