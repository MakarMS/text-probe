<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts WebSocket URLs.
 */
class WebsocketUrlProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $probes = [
            new WsUrlProbe(),
            new WssUrlProbe(),
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
     * @return ProbeType returns ProbeType::WEBSOCKET_URL
     */
    #[\Override]
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::WEBSOCKET_URL;
    }
}
