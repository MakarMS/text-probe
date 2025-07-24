<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use TextProbe\Enums\ProbeType;
use TextProbe\Result;

class ResultTest extends TestCase
{
    public function testResultProperties(): void
    {
        $type = ProbeType::EMAIL;
        $value = 'test@example.com';
        $start = 10;
        $end = 26;

        $result = new Result($type, $value, $start, $end);

        $this->assertSame($type, $result->getProbeEnum());
        $this->assertSame($value, $result->getResult());
        $this->assertSame($start, $result->getStart());
        $this->assertSame($end, $result->getEnd());
    }
}
