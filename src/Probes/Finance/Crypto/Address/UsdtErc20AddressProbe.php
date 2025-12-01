<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USDT ERC-20 addresses from text.
 *
 * This probe matches 0x-prefixed, 40-hex-character addresses typically used
 * for USDT tokens on Ethereum and other EVM-compatible networks.
 */
class UsdtErc20AddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b0x[a-fA-F0-9]{40}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDT_ERC20_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDT_ERC20_ADDRESS;
    }
}
