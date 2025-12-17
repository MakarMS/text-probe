<?php

namespace TextProbe\Probes\Contact;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Identity\InnValidator;

/**
 * Probe that extracts Russian Tax Identification Numbers (INN) from text.
 *
 * Matches 10-digit organization INNs and 12-digit individual INNs, applying
 * {@see InnValidator} by default to filter out values with incorrect checksums.
 */
class RussianInnProbe extends Probe implements IProbe
{
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new InnValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{10}(\d{2})?\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::RUSSIAN_INN
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RUSSIAN_INN;
    }
}
