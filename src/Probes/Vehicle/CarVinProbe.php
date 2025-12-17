<?php

namespace TextProbe\Probes\Vehicle;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Vehicle\CarVinValidator;

/**
 * Probe that extracts and validates vehicle identification numbers (VINs).
 *
 * Matches 17-character VINs, excluding forbidden characters and validating
 * the check digit via {@see CarVinValidator} by default.
 */
class CarVinProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional custom validator to override
     *                                   the default VIN validation rules
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new CarVinValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<![A-Z0-9])[A-HJ-NPR-Z0-9]{17}(?![A-Z0-9])/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::CAR_VIN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::CAR_VIN;
    }
}
