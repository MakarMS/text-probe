<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts ssh-ed25519 public keys.
 */
class SshEd25519PublicKeyProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        $regex = '~\bssh-ed25519\s+[A-Za-z0-9+/]+={0,3}(?:\s+[^ \r\n]+)?\b~';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::SSH_ED25519_PUBLIC_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SSH_ED25519_PUBLIC_KEY;
    }
}
