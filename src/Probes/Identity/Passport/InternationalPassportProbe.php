<?php

namespace TextProbe\Probes\Identity\Passport;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;
use Override;

/**
 * Probe that extracts MRZ passport blocks.
 */
class InternationalPassportProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $probes = [
            new MrzTd1Probe(),
            new MrzTd2Probe(),
            new MrzTd3Probe(),
        ];

        foreach ($probes as $probe) {
            $results = $probe->probe($text);

            if ($results !== []) {
                return array_map(
                    fn (Result $result) => new Result(
                        $this->getProbeType(),
                        $result->getResult(),
                        $result->getStart(),
                        $result->getEnd(),
                    ),
                    $results,
                );
            }
        }

        return [];
    }

    /**
     * @return ProbeType returns ProbeType::INTERNATIONAL_PASSPORT
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::INTERNATIONAL_PASSPORT;
    }
}
