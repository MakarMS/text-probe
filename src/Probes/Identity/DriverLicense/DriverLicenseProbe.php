<?php

namespace TextProbe\Probes\Identity\DriverLicense;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts driver license numbers.
 */
class DriverLicenseProbe extends Probe implements IProbe
{
    #[\Override]
    public function probe(string $text): array
    {
        $probes = [
            new UkDrivingLicenceNumberProbe(),
            new DeFuehrerscheinnummerProbe(),
            new FrNumeroPermisDeConduireProbe(),
            new ItNumeroPatenteProbe(),
            new EsNumeroPermisoConducirProbe(),
            new NlRijbewijsNummerProbe(),
            new PlNumerPrawaJazdyProbe(),
            new SeKoerkortsnummerProbe(),
            new NoFoererkortnummerProbe(),
            new ChFuehrerausweisNummerProbe(),
            new RuVoditelskoeUdostoverenieProbe(),
            new UsDriverLicenseNumberProbe(),
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
     * @return ProbeType returns ProbeType::DRIVER_LICENSE
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::DRIVER_LICENSE;
    }
}
