<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Identity\TaxNumber\ItCodiceFiscaleControlCharValidator;
use Override;

/**
 * Probe that extracts Italian Codice Fiscale identifiers.
 */
class ItCodiceFiscaleProbe extends Probe implements IProbe
{
    public function __construct(?ItCodiceFiscaleControlCharValidator $validator = null)
    {
        parent::__construct($validator ?? new ItCodiceFiscaleControlCharValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::IT_CODICE_FISCALE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::IT_CODICE_FISCALE;
    }
}
