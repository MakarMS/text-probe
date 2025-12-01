<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USDT TRC-20 addresses from text.
 *
 * This probe matches TRON-style addresses starting with "T" and having a total
 * length of 34 characters, which is the typical format used for USDT on the
 * TRC-20 (TRON) network.
 */
class UsdtTrc20AddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bT[1-9A-Za-z]{33}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDT_TRC20_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDT_TRC20_ADDRESS;
    }
}
