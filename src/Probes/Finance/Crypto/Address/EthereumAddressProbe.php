<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Ethereum addresses from text.
 *
 * This probe matches 0x-prefixed, 40-hex-character addresses, accepting both
 * checksummed and lowercase/uppercase representations typically used for
 * Ethereum and EVM-compatible chains.
 */
class EthereumAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b0x[a-fA-F0-9]{40}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_ETHEREUM_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_ETHEREUM_ADDRESS;
    }
}
