<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

class UsdtErc20AddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b0x[a-fA-F0-9]{40}\b/i', $text);
    }

    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDT_ERC20_ADDRESS;
    }
}
