<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts cryptocurrency transaction identifiers.
 */
class CryptoTransactionIdProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:0x[a-fA-F0-9]{64}|[A-F0-9]{64}|[a-fA-F0-9]{64}|[1-9A-HJ-NP-Za-km-z]{87,88}|[A-Z2-7]{52})\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_TRANSACTION_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_TRANSACTION_ID;
    }
}
