<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Ethereum transaction Hash values.
 */
class EthereumTxHashProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b0x[a-fA-F0-9]{64}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_ETHEREUM_TX_HASH
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_ETHEREUM_TX_HASH;
    }
}
