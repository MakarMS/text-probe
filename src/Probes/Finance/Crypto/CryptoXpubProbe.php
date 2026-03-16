<?php

namespace TextProbe\Probes\Finance\Crypto;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Crypto Xpub values from text.
 *
 * Examples:
 * - valid: `xpub661MyMwAqRbcFJx2wEJQG6fM7xA2qMafmD2Q9x8ZBv7q`
 * - invalid: `xpub-short`
 *
 * Constraints:
 * - Uses regex pattern `/\b(?:xpub|ypub|zpub|tpub)[1-9A-HJ-NP-Za-km-z]{20,}\b/`.
 * - Relies on regex filtering only (no additional validator).
 */
class CryptoXpubProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b(?:xpub|ypub|zpub|tpub)[1-9A-HJ-NP-Za-km-z]{20,}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_XPUB
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_XPUB;
    }
}
