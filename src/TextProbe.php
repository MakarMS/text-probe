<?php

namespace TextProbe;

use TextProbe\Probes\Contracts\IProbe;

class TextProbe
{
    /** @var $probes Array<IProbe> */
    private array $probes = [];

    public function addProbe(IProbe $probe): void
    {
        $this->probes[] = $probe;
    }

    /** @return Array<Result> */
    public function analyze(string $text): array
    {
        $results = [];

        foreach ($this->probes as $probe) {
            array_push($results, ...$probe->probe($text));
        }

        return $results;
    }

    public function clean(): void
    {
        $this->probes = [];
    }
}