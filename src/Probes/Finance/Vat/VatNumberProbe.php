<?php

namespace TextProbe\Probes\Finance\Vat;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts VAT numbers across supported regions.
 */
class VatNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $probes = [
            new ChUidMwstProbe(),
            new NoOrgnrMvaProbe(),
            new NlBtwNummerProbe(),
            new AtUidProbe(),
            new BeVatNumberProbe(),
            new BgVatNumberProbe(),
            new CyVatNumberProbe(),
            new CzDicProbe(),
            new DeUstIdNrProbe(),
            new DkCvrProbe(),
            new EeKmkrProbe(),
            new EsNifIvaProbe(),
            new FiAlvNumeroProbe(),
            new FrNumeroTvaIntracommunautaireProbe(),
            new GrAfmVatProbe(),
            new HrOibVatProbe(),
            new HuAdoazonositoJelVatProbe(),
            new IeVatNumberProbe(),
            new ItPartitaIvaProbe(),
            new LtPvmMoketojoKodasProbe(),
            new LuNumeroTvaProbe(),
            new LvPvnRegNrProbe(),
            new MtVatNumberProbe(),
            new PlNipVatProbe(),
            new PtNifIvaProbe(),
            new RoCuiVatProbe(),
            new SeVatNummerProbe(),
            new SiDavcnaStevilkaVatProbe(),
            new SkDicVatProbe(),
            new GbVatNumberProbe(),
            new XiVatNumberProbe(),
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
     * @return ProbeType returns ProbeType::VAT_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::VAT_NUMBER;
    }
}
