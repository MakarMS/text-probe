<?php

namespace TextProbe\Probes\Contracts;

use TextProbe\Result;

interface IProbe
{
    /** @return Array<Result> */
    public function probe(string $text): array;
}
