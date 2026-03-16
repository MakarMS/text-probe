<?php

namespace TextProbe\Probes\Logistics\Tracking;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts tracking numbers across supported carriers.
 */
class TrackingNumberProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $probes = [
            new RoyalMailS10Probe(),
            new LaPosteColissimoS10Probe(),
            new CorreosS10Probe(),
            new BpostS10Probe(),
            new DeutschePostS10Probe(),
            new SwissPostS10Probe(),
            new PosteItalianeS10Probe(),
            new PocztaPolskaS10Probe(),
            new PostNordS10Probe(),
            new RussiaPostS10Probe(),
            new UspsIntlS10Probe(),
            new Ups1ZTrackingProbe(),
            new DhlExpress10Probe(),
            new DpdTrackingProbe(),
            new GlsTrackingProbe(),
            new Fedex12Probe(),
            new Fedex15Probe(),
            new Fedex20Probe(),
            new UspsNumeric20Probe(),
            new UspsNumeric22Probe(),
            new HermesEvriTrackingProbe(),
            new PostnlTrackingProbe(),
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
     * @return ProbeType returns ProbeType::TRACKING_NUMBER
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::TRACKING_NUMBER;
    }
}
