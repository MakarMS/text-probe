<?php

namespace TextProbe\Probes\Barcode;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;
use Override;

/**
 * Probe that extracts barcode values across supported formats.
 */
class BarcodeValueProbe extends Probe implements IProbe
{
    #[Override]
    public function probe(string $text): array
    {
        $probes = [
            new Ean13Probe(),
            new UpcAProbe(),
        ];

        $results = [];
        $seen = [];

        foreach ($probes as $probe) {
            $probeResults = $probe->probe($text);

            if ($probeResults === []) {
                continue;
            }

            foreach ($probeResults as $result) {
                $key = $result->getStart() . '-' . $result->getEnd() . '-' . $result->getResult();

                if (isset($seen[$key])) {
                    continue;
                }

                $seen[$key] = true;
                $results[] = new Result(
                    $this->getProbeType(),
                    $result->getResult(),
                    $result->getStart(),
                    $result->getEnd(),
                );
            }
        }

        return $results;
    }

    /**
     * @return ProbeType returns ProbeType::BARCODE_VALUE
     */
    #[Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::BARCODE_VALUE;
    }
}
