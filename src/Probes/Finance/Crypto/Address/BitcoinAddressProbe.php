<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Bitcoin addresses from text.
 *
 * This probe supports legacy Base58Check-style addresses starting with "1" or "3"
 * as well as Bech32 "bc1" SegWit addresses, matching typical Bitcoin address
 * lengths while trying to avoid obvious false positives.
 */
class BitcoinAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:1|3|bc1)[a-zA-HJ-NP-Z0-9]{25,62}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_BITCOIN_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_BITCOIN_ADDRESS;
    }
}
