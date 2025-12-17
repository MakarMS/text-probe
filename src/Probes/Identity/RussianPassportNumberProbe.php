<?php

namespace TextProbe\Probes\Identity;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Identity\RussianPassportNumberValidator;

/**
 * Probe that extracts Russian internal passport numbers from text.
 *
 * This probe matches common formats with or without separators (spaces or
 * dashes) between the series and number parts and, by default, validates
 * candidates using {@see RussianPassportNumberValidator} to reduce false
 * positives.
 */
class RussianPassportNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator to apply additional
     *                                   or alternative checks to detected passport numbers.
     *                                   If not provided, {@see RussianPassportNumberValidator}
     *                                   is used by default.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new RussianPassportNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex(
            '/(?<!\d)(\d{2})[\s-]?(\d{2})[\s-]?(\d{6})(?!\d)/u',
            $text,
        );
    }

    /**
     * @return ProbeType returns ProbeType::RUSSIAN_PASSPORT_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::RUSSIAN_PASSPORT_NUMBER;
    }
}
