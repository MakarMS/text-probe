<?php

namespace TextProbe\Probes\Finance;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Company\OgrnNumberValidator;

/**
 * Probe that extracts Russian OGRN (Primary State Registration) numbers.
 *
 * Matches 13-digit sequences that satisfy the official checksum rule for OGRN
 * identifiers. By default, candidates are validated using
 * {@see OgrnNumberValidator} to reduce false positives in numeric text.
 */
class OgrnNumberProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator Optional custom validator. If omitted,
     *                                   {@see OgrnNumberValidator} is used.
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new OgrnNumberValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\b\d{13}\b/u', $text);
    }

    /**
     * @return ProbeType returns ProbeType::OGRN_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::OGRN_NUMBER;
    }
}
