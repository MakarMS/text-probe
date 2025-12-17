<?php

namespace TextProbe\Probes\Social;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Social\UsSocialSecurityNumberValidator;

/**
 * Probe that extracts U.S. Social Security Numbers (SSN) from text.
 *
 * The probe matches numbers strictly in the `XXX-XX-XXXX` format and relies on
 * {@see UsSocialSecurityNumberValidator} to filter out structurally invalid
 * combinations such as disallowed area, group, or serial numbers.
 */
class UsSocialSecurityNumberProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new UsSocialSecurityNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)\d{3}-\d{2}-\d{4}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::US_SOCIAL_SECURITY_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::US_SOCIAL_SECURITY_NUMBER;
    }
}
