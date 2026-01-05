<?php

namespace TextProbe\Probes\Web;

use BackedEnum;
use TextProbe\Enums\ProbeType;
use TextProbe\Probes\Contracts\IProbe;
use TextProbe\Probes\Probe;
use TextProbe\Result;

/**
 * Probe that extracts HTTP status codes from lines.
 */
class HttpStatusCodeProbe extends Probe implements IProbe
{
    public function probe(string $text): array
    {
        $regex = '/(?m)^(?:HTTP\/\d(?:\.\d)?\s)?([1-5]\d{2})$/';
        preg_match_all($regex, $text, $matches, PREG_OFFSET_CAPTURE);

        if ($matches[1] === []) {
            return [];
        }

        $results = [];
        foreach ($matches[1] as [$match, $byteOffset]) {
            $charOffset = mb_strlen(substr($text, 0, $byteOffset));
            $charLength = mb_strlen($match);

            $results[] = new Result(
                $this->getProbeType(),
                $match,
                $charOffset,
                $charOffset + $charLength,
            );
        }

        return $results;
    }

    /**
     * @return ProbeType returns ProbeType::HTTP_STATUS_CODE
     */
    protected function getProbeType(): BackedEnum
    {
        return ProbeType::HTTP_STATUS_CODE;
    }
}
