<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USDC addresses on the Solana network from text.
 *
 * This probe matches Solana-style Base58 public keys with lengths between
 * 32 and 44 characters, interpreted as USDC token or wallet addresses when
 * used in the appropriate context.
 */
class UsdcSolanaAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[1-9A-HJ-NP-Za-km-z]{32,44}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDC_SOLANA_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_SOLANA_ADDRESS;
    }
}
