<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts ssh-rsa public keys.
 */
class SshRsaPublicKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $regex = '~\bssh-rsa\s+[A-Za-z0-9+/]+={0,3}(?:\s+[^ \r\n]+)?\b~';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::SSH_RSA_PUBLIC_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SSH_RSA_PUBLIC_KEY;
    }
}
