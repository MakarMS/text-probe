<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Validator\Web\BalancedBracesValidator;

/**
 * Probe that extracts GraphQL selection sets.
 */
class GraphqlSelectionSetProbe extends Probe implements IProbe
{
    public function __construct(?BalancedBracesValidator $validator = null)
    {
        parent::__construct($validator ?? new BalancedBracesValidator());
    }

    public function probe(string $text): array
    {
        return $this->findByRegex('/(?ms)^\{.*}$/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GRAPHQL_SELECTION_SET
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GRAPHQL_SELECTION_SET;
    }
}
