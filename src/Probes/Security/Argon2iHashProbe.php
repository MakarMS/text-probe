<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts Argon2i password hashes.
 *
 * Matches Argon2i hashes with non-zero m/t/p parameters.
 */
class Argon2iHashProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $regex = '~\$argon2i\$v=\d+\$m=[1-9]\d*,t=[1-9]\d*,p=[1-9]\d*\$[A-Za-z0-9+/]+={0,2}\$[A-Za-z0-9+/]+={0,2}~';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::ARGON2I_HASH
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ARGON2I_HASH;
    }
}
