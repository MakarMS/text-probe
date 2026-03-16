<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts common password hash formats.
 *
 * Matches bcrypt, Argon2id, and Argon2i hashes.
 */
class PasswordHashProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $bcrypt = '\\$(?:2a|2b|2y)\\$(?:0[4-9]|[12][0-9]|3[01])\\$[./A-Za-z0-9]{53}';
        $argon2id = '\\$argon2id\\$v=\\d+\\$m=[1-9]\\d*,t=[1-9]\\d*,p=[1-9]\\d*\\$[A-Za-z0-9+/]+={0,2}\\$[A-Za-z0-9+/]+={0,2}';
        $argon2i = '\\$argon2i\\$v=\\d+\\$m=[1-9]\\d*,t=[1-9]\\d*,p=[1-9]\\d*\\$[A-Za-z0-9+/]+={0,2}\\$[A-Za-z0-9+/]+={0,2}';

        return $this->findByRegex('~(?:' . $bcrypt . '|' . $argon2id . '|' . $argon2i . ')~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PASSWORD_HASH
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PASSWORD_HASH;
    }
}
