<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Web\CsrfTokenHexValidator;

/**
 * Probe that extracts hexadecimal CSRF tokens.
 *
 * Matches 32-128 character hex tokens and validates even length.
 */
class CsrfTokenHexProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to customize CSRF
     *                                   token validation rules
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new CsrfTokenHexValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b[a-fA-F0-9]{32,128}\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CSRF_TOKEN_HEX
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CSRF_TOKEN_HEX;
    }
}
