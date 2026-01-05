<?php

namespace TextProbe\Probes\Finance\Reference;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts invoice identifiers.
 */
class InvoiceNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $probes = [
            new InvoiceNumericIdProbe(),
            new InvoiceAlnumIdProbe(),
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
     * @return ProbeType returns ProbeType::INVOICE_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::INVOICE_NUMBER;
    }
}
