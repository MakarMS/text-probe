<?php

namespace TextProbe\Probes\Identity\MedicalPolicy;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts medical policy numbers across supported regions.
 */
class MedicalPolicyNumberProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        $probes = [
            new DeKrankenversichertennummerProbe(),
            new FrNirProbe(),
            new ItTesseraSanitariaProbe(),
            new EsSipNumberProbe(),
            new NlBsnMedicalProbe(),
            new PlPeselMedicalProbe(),
            new SePersonnummerMedicalProbe(),
            new NoFoedselsnummerMedicalProbe(),
            new ChAhvMedicalProbe(),
            new GbNhsNumberProbe(),
            new RuOmsEnp16Probe(),
            new UsMemberIdProbe(),
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
     * @return ProbeType returns ProbeType::MEDICAL_POLICY_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::MEDICAL_POLICY_NUMBER;
    }
}
