<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Solana transaction Signature values.
 */
class SolanaTxSignatureProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[1-9A-HJ-NP-Za-km-z]{87,88}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_SOLANA_TX_SIGNATURE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_SOLANA_TX_SIGNATURE;
    }
}
