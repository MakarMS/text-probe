<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class BitcoinAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:1|3|bc1)[a-zA-HJ-NP-Z0-9]{25,62}\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_BITCOIN_ADDRESS;
    }
}
