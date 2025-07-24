<?php

namespace TextProbe;

use BackedEnum;

class Result
{
    private BackedEnum $probeEnum;
    private string $result;
    private int $start;
    private int $end;

    public function __construct(BackedEnum $probeEnum, string $result, int $start, int $end)
    {
        $this->probeEnum = $probeEnum;
        $this->result = $result;
        $this->start = $start;
        $this->end = $end;
    }

    public function getProbeEnum(): BackedEnum
    {
        return $this->probeEnum;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }
}