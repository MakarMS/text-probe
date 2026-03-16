<?php

namespace TextProbe\Probes\Barcode;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Barcode\UpcAChecksumValidator;
use Override;

/**
 * Probe that extracts UPC-A barcodes.
 */
class UpcAProbe extends Probe implements IProbe
{
    public function __construct(?UpcAChecksumValidator $validator = null)
    {
        parent::__construct($validator ?? new UpcAChecksumValidator());
    }

    #[Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?<!\d)\d{12}(?!\d)/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::UPC_A
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::UPC_A;
    }
}
