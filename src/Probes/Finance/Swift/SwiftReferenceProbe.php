<?php

namespace TextProbe\Probes\Finance\Swift;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts SWIFT references.
 */
class SwiftReferenceProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $probes = [
            new UetrProbe(),
            new SwiftField20ReferenceProbe(),
        ];

        $results = [];
        foreach ($probes as $probe) {
            $probeResults = $probe->probe($text);

            if ($probeResults === []) {
                continue;
            }

            $results = array_merge(
                $results,
                array_map(
                    fn (Result $result) => new Result(
                        $this->getProbeType(),
                        $result->getResult(),
                        $result->getStart(),
                        $result->getEnd(),
                    ),
                    $probeResults,
                ),
            );
        }

        return $results;
    }

    /**
     * @return ProbeType returns ProbeType::SWIFT_REFERENCE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::SWIFT_REFERENCE;
    }
}
