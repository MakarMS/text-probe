<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Security\PrivateKeyBlockValidator;

/**
 * Probe that extracts OpenSSH private key blocks.
 */
class OpenSshPrivateKeyProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to customize private
     *                                   key block validation
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new PrivateKeyBlockValidator());
    }

    public function probe(string $text): array
    {
        $regex = '/-----BEGIN OPENSSH PRIVATE KEY-----[\s\S]+?-----END OPENSSH PRIVATE KEY-----/';

        return $this->findByRegex($regex, $text);
    }

    /**
     * @return ProbeType returns ProbeType::OPENSSH_PRIVATE_KEY
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OPENSSH_PRIVATE_KEY;
    }
}
