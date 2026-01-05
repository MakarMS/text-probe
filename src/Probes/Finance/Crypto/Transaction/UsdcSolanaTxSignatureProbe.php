<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts UsdcSolana transaction Signature values.
 */
class UsdcSolanaTxSignatureProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[1-9A-HJ-NP-Za-km-z]{87,88}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDC_SOLANA_TX_SIGNATURE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_SOLANA_TX_SIGNATURE;
    }
}
