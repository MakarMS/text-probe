<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Ripple (XRP) addresses from text.
 *
 * This probe matches Base58-style Ripple addresses starting with "r" and
 * typical lengths between 26 and 35 characters, while attempting to avoid
 * obvious false positives using word-boundary style checks.
 */
class RippleAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<![A-Za-z0-9])r[1-9A-HJ-NP-Za-km-z]{25,34}(?![A-Za-z0-9])/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_RIPPLE_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_RIPPLE_ADDRESS;
    }
}
