<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts UsdcErc20 transaction Hash values.
 */
class UsdcErc20TxHashProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b0x[a-fA-F0-9]{64}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDC_ERC20_TX_HASH
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_ERC20_TX_HASH;
    }
}
