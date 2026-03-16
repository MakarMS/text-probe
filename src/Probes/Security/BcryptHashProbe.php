<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts bcrypt password hashes.
 *
 * Matches bcrypt hashes with $2a$, $2b$, or $2y$ prefixes and cost 04-31.
 */
class BcryptHashProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $regex = '~\$(?:2a|2b|2y)\$(?:0[4-9]|[12][0-9]|3[01])\$[./A-Za-z0-9]{53}\b~';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::BCRYPT_HASH
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BCRYPT_HASH;
    }
}
