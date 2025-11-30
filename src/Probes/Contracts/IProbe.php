<?php

namespace TextProbe\Probes\Contracts;

use TextProbe\Result;

interface IProbe
{
    /** @return array<Result> */
    public function probe(string $text): array;
}
