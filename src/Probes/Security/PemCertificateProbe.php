<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts PEM-encoded certificate blocks.
 */
class PemCertificateProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $regex = '/-----BEGIN CERTIFICATE-----[\s\S]+?-----END CERTIFICATE-----/';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::PEM_CERTIFICATE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PEM_CERTIFICATE;
    }
}
