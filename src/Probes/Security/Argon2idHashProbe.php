<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts Argon2id password hashes.
 *
 * Matches Argon2id hashes with non-zero m/t/p parameters.
 */
class Argon2idHashProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $regex = '~\$argon2id\$v=\d+\$m=[1-9]\d*,t=[1-9]\d*,p=[1-9]\d*\$[A-Za-z0-9+/]+={0,2}\$[A-Za-z0-9+/]+={0,2}~';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::ARGON2ID_HASH
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::ARGON2ID_HASH;
    }
}
