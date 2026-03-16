<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Security\PrivateKeyBlockValidator;

/**
 * Probe that extracts PEM-encoded PKCS#8 private key blocks.
 */
class PemPkcs8PrivateKeyProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to customize private
     *                                   key block validation
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new PrivateKeyBlockValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        $regex = '/-----BEGIN PRIVATE KEY-----[\s\S]+?-----END PRIVATE KEY-----/';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::PEM_PKCS8_PRIVATE_KEY
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PEM_PKCS8_PRIVATE_KEY;
    }
}
