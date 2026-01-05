<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts OpenSSH public key lines.
 */
class SshPublicKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $patterns = [
            'ssh-rsa\s+[A-Za-z0-9+/]+={0,3}(?:\s+[^ \r\n]+)?',
            'ssh-ed25519\s+[A-Za-z0-9+/]+={0,3}(?:\s+[^ \r\n]+)?',
            'ecdsa-sha2-nistp(?:256|384|521)\s+[A-Za-z0-9+/]+={0,3}(?:\s+[^ \r\n]+)?',
        ];

        return $this->findByRegex('~\b(?:' . implode('|', $patterns) . ')\b~', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SSH_PUBLIC_KEY
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SSH_PUBLIC_KEY;
    }
}
