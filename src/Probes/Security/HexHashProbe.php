<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts long hexadecimal hash strings from text.
 *
 * Detects common cryptographic digests such as MD5 (32 chars), SHA-1 (40 chars),
 * SHA-224 (56 chars), SHA-256 (64 chars), SHA-384 (96 chars) and SHA-512
 * (128 chars). Matches are bounded to avoid capturing fragments embedded within
 * longer alphanumeric strings.
 */
class HexHashProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<![A-Fa-f0-9])(?:[A-Fa-f0-9]{32}|[A-Fa-f0-9]{40}|[A-Fa-f0-9]{56}|[A-Fa-f0-9]{64}|[A-Fa-f0-9]{96}|[A-Fa-f0-9]{128})(?![A-Fa-f0-9])/',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::HEX_HASH
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HEX_HASH;
    }
}
