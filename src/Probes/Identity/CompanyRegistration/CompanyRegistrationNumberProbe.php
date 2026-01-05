<?php

namespace TextProbe\Probes\Identity\CompanyRegistration;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts company registration numbers across supported regions.
 */
class CompanyRegistrationNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $probes = [
            new DeHandelsregisternummerProbe(),
            new FrSirenProbe(),
            new FrSiretProbe(),
            new ItCodiceReaProbe(),
            new EsCifProbe(),
            new NlKvKNummerProbe(),
            new PlKrsProbe(),
            new SeOrganisationsnummerProbe(),
            new NoOrganisasjonsnummerProbe(),
            new ChUidiProbe(),
            new UkCompanyNumberProbe(),
            new RuOgrnProbe(),
            new UsCompanyRegistrationNumberProbe(),
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
     * @return ProbeType returns ProbeType::COMPANY_REGISTRATION_NUMBER
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::COMPANY_REGISTRATION_NUMBER;
    }
}
