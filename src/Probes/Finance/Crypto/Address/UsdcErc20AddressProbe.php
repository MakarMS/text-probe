<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USDC ERC-20 contract-style addresses from text.
 *
 * This probe matches 0x-prefixed, 40-hex-character addresses typically used
 * for USDC on Ethereum and other EVM-compatible networks.
 */
class UsdcErc20AddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b0x[a-fA-F0-9]{40}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDC_ERC20_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_ERC20_ADDRESS;
    }
}
