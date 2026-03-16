<?php

namespace TextProbe\Probes\Security;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Security\PrivateKeyBlockValidator;
use Override;

/**
 * Probe that extracts private key blocks in PEM or OpenSSH formats.
 */
class PrivateKeyProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to customize private
     *                                   key block validation
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new PrivateKeyBlockValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        $patterns = [
            '-----BEGIN RSA PRIVATE KEY-----[\s\S]+?-----END RSA PRIVATE KEY-----',
            '-----BEGIN PRIVATE KEY-----[\s\S]+?-----END PRIVATE KEY-----',
            '-----BEGIN OPENSSH PRIVATE KEY-----[\s\S]+?-----END OPENSSH PRIVATE KEY-----',
        ];

        return $this->findByRegex('/(?:' . implode('|', $patterns) . ')/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::PRIVATE_KEY
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::PRIVATE_KEY;
    }
}
