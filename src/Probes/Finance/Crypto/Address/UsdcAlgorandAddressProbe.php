<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class UsdcAlgorandAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z2-7]{58}\b/', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS;
    }
}
