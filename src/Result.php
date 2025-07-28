<?php

namespace TextProbe;

use BackedEnum;

class Result
{
    private BackedEnum $probeType;
    private string $result;
    private int $start;
    private int $end;

    public function __construct(BackedEnum $probeType, string $result, int $start, int $end)
    {
        $this->probeType = $probeType;
        $this->result = $result;
        $this->start = $start;
        $this->end = $end;
    }

    public function getProbeType(): BackedEnum
    {
        return $this->probeType;
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