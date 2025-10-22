<?php

namespace TextProbe;

use TextProbe\Probes\Contracts\IProbe;

class TextProbe
{
    /** @var IProbe[] */
    private array $probes = [];

    public function addProbe(IProbe $probe): void
    {
        $this->probes[] = $probe;
    }

    /**
     * @return Result[]
     */
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
