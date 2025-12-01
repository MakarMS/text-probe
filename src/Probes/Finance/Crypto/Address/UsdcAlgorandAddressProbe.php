<?php

namespace TextProbe\Probes\Finance\Crypto\Address;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts USDC addresses on the Algorand network from text.
 *
 * This probe matches Algorand-style Base32 addresses consisting of 58
 * characters using the character set A–Z and 2–7, which is the standard
 * representation for Algorand account addresses (including USDC wallets).
 */
class UsdcAlgorandAddressProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[A-Z2-7]{58}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CRYPTO_USDC_ALGORAND_ADDRESS;
    }
}
