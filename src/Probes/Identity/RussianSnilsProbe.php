<?php

namespace TextProbe\Probes\Identity;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Identity\RussianSnilsValidator;

/**
 * Probe that extracts Russian SNILS numbers from text.
 *
 * Matches 11-digit SNILS values written as plain digits or with standard
 * separators (e.g., `123-456-789 01`), validating each candidate with
 * {@see RussianSnilsValidator} to ensure checksum correctness.
 */
class RussianSnilsProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional validator to customize SNILS
     *                                   validation rules. Defaults to
     *                                   {@see RussianSnilsValidator}.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new RussianSnilsValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{3}-?\d{3}-?\d{3}\s?\d{2}\b/u', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SNILS
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RUSSIAN_SNILS;
    }
}
