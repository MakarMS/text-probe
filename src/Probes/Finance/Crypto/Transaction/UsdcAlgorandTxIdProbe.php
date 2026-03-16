<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts UsdcAlgorand transaction Id values.
 */
class UsdcAlgorandTxIdProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z2-7]{52}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDC_ALGORAND_TX_ID
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_ALGORAND_TX_ID;
    }
}
