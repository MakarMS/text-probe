<?php

namespace TextProbe\Probes;

use BackedEnum;
use TextProbe\Result;

abstract class Probe
{
    /** @return Array<Result> */
    protected function findByRegex(string $regex, string $text): array
    {
        preg_match_all($regex, $text, $matches, PREG_OFFSET_CAPTURE);

        $results = [];
        foreach ($matches[0] as [$match, $byteOffset]) {
            $charOffset = mb_strlen(substr($text, 0, $byteOffset));
            $charLength = mb_strlen($match);

            $results[] = new Result($this->getProbeType(), $match, $charOffset, $charOffset + $charLength);
        }

        return $results;
    }

    abstract protected function getProbeType(): BackedEnum;
}