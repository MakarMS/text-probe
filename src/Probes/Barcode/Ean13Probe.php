<?php

namespace TextProbe\Probes\Barcode;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Barcode\Ean13ChecksumValidator;

/**
 * Probe that extracts EAN-13 barcodes.
 */
class Ean13Probe extends Probe implements IProbe
{
    public function __construct(?Ean13ChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new Ean13ChecksumValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)\d{13}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::EAN_13
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::EAN_13;
    }
}
