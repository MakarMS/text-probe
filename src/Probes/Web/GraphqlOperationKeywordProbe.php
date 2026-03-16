<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;

/**
 * Probe that extracts GraphQL operation keywords.
 */
class GraphqlOperationKeywordProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        return $this->findByRegex('/(?m)\b(query|mutation|subscription)\b/', $text);
    }

    /**
     * @return ProbeType returns ProbeType::GRAPHQL_OPERATION_KEYWORD
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::GRAPHQL_OPERATION_KEYWORD;
    }
}
