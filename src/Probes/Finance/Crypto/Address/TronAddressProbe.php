<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts TRON (TRX / TRC-20) addresses from text.
 *
 * This probe matches Base58-style TRON addresses starting with "T" and
 * having a total length of 34 characters, which is the typical format
 * used for TRON account addresses.
 */
class TronAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\bT[1-9A-HJ-NP-Za-km-z]{33}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_TRON_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_TRON_ADDRESS;
    }
}
