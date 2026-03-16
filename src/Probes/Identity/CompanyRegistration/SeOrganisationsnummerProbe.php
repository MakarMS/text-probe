<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\CompanyRegistration\SeOrganisationnummerChecksumValidator;
use Override;

/**
 * Probe that extracts Swedish organisation numbers.
 */
class SeOrganisationsnummerProbe extends Probe implements IProbe
{
    public function __construct(?SeOrganisationnummerChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new SeOrganisationnummerChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^\d{6}-\d{4}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SE_ORGANISATIONSNUMMER
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SE_ORGANISATIONSNUMMER;
    }
}
