<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use Override;

/**
 * Probe that extracts public key or certificate PEM blocks.
 */
class PublicKeyProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $patterns = [
            '-----BEGIN PUBLIC KEY-----[\s\S]+?-----END PUBLIC KEY-----',
            '-----BEGIN CERTIFICATE-----[\s\S]+?-----END CERTIFICATE-----',
        ];

        return $this->findByRegex('/(?:' . implode('|', $patterns) . ')/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PUBLIC_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PUBLIC_KEY;
    }
}
