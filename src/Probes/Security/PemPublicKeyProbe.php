<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts PEM-encoded public key blocks.
 */
class PemPublicKeyProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $regex = '/-----BEGIN PUBLIC KEY-----[\s\S]+?-----END PUBLIC KEY-----/';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::PEM_PUBLIC_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PEM_PUBLIC_KEY;
    }
}
