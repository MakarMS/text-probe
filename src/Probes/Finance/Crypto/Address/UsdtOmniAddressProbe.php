<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USDT Omni Layer addresses from text.
 *
 * This probe matches Bitcoin-style Base58Check addresses starting with "1" or "3"
 * with typical lengths between 26 and 35 characters, which are used for USDT on
 * the Omni Layer (Bitcoin-based) network.
 */
class UsdtOmniAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[13][a-zA-HJ-NP-Z0-9]{25,34}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDT_OMNI_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDT_OMNI_ADDRESS;
    }
}
