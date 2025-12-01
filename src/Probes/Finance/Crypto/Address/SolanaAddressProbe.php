<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Solana addresses from text.
 *
 * This probe matches Base58-encoded public keys with lengths between 32 and
 * 44 characters, which is the typical format used for Solana account addresses.
 */
class SolanaAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[1-9A-HJ-NP-Za-km-z]{32,44}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_SOLANA_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_SOLANA_ADDRESS;
    }
}
