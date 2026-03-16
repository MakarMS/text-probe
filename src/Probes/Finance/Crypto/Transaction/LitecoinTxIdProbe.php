<?php

namespace TextProbe\Probes\Finance\Crypto\Transaction;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Litecoin transaction Id values.
 */
class LitecoinTxIdProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-fA-F0-9]{64}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_LITECOIN_TX_ID
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_LITECOIN_TX_ID;
    }
}
