<?php

namespace TextProbe\Probes\Finance\Reference;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Contracts\IValidator;
use TextProbe\Validator\Finance\Reference\Mod97Validator;

/**
 * Probe that extracts SEPA RF references.
 */
class SepaRfReferenceProbe extends Probe implements IProbe
{
    /**
     * @param IValidator|null $validator optional validator to override Mod-97
     *                                   verification
     */
    public function __construct(?IValidator $validator = null)
    {
        parent::__construct($validator ?? new Mod97Validator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/\bRF\d{2}[A-Z0-9]{1,21}\b/i', $text);
    }

    /**
     * @return ProbeType returns ProbeType::SEPA_RF_REFERENCE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SEPA_RF_REFERENCE;
    }
}
