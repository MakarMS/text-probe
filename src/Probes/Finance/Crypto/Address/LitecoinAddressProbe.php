<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Litecoin addresses from text.
 *
 * This probe supports legacy Base58Check-style Litecoin addresses starting
 * with "L" or "M" as well as Bech32 "ltc1" SegWit addresses, matching typical
 * Litecoin address lengths while trying to avoid obvious false positives.
 */
class LitecoinAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[LM][a-zA-HJ-NP-Z0-9]{25,34}\b|\bltc1[a-z0-9]{25,62}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_LITECOIN_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_LITECOIN_ADDRESS;
    }
}
