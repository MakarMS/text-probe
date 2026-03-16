<?php

namespace TextProbe\Probes\Identity\TaxNumber;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts tax numbers across supported regions.
 */
class TaxNumberProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        $probes = [
            new DeSteuerIdProbe(),
            new DeSteuernummerProbe(),
            new FrNumeroFiscalReferenceProbe(),
            new ItCodiceFiscaleProbe(),
            new EsNifProbe(),
            new NlBsnProbe(),
            new PlPeselProbe(),
            new PlNipProbe(),
            new SePersonnummerProbe(),
            new NoFoedselsnummerProbe(),
            new ChAhvNummerProbe(),
            new GbUtrProbe(),
            new RuInnProbe(),
            new UsEinProbe(),
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
     * @return ProbeType returns ProbeType::TAX_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TAX_NUMBER;
    }
}
