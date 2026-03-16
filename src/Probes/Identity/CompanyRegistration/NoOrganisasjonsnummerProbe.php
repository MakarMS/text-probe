<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\CompanyRegistration\NoOrganisasjonsnummerChecksumValidator;

/**
 * Probe that extracts Norwegian organisation numbers.
 */
class NoOrganisasjonsnummerProbe extends Probe implements IProbe
{
    public function __construct(?NoOrganisasjonsnummerChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new NoOrganisasjonsnummerChecksumValidator());
    }

    #[\Override]

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{9}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::NO_ORGANISASJONSNUMMER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::NO_ORGANISASJONSNUMMER;
    }
}
