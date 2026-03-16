<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts ECDSA public keys in OpenSSH format.
 */
class SshEcdsaPublicKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $regex = '~\becdsa-sha2-nistp(?:256|384|521)\s+[A-Za-z0-9+/]+={0,3}(?:\s+[^ \r\n]+)?\b~';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::SSH_ECDSA_PUBLIC_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SSH_ECDSA_PUBLIC_KEY;
    }
}
